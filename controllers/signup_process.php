<?php
session_start();
header('Content-Type: application/json');

// Include database connection
require_once '../config/DBconnection.php';

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

// Server-side validation
$fullName = trim($_POST['fullName'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validate inputs
$errors = [];

if (empty($fullName)) {
    $errors[] = "Full name is required";
} elseif (strlen($fullName) < 3) {
    $errors[] = "Full name must be at least 3 characters";
} elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $fullName)) {
    $errors[] = "Full name should only contain letters";
}

if (empty($email)) {
    $errors[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

if (empty($password)) {
    $errors[] = "Password is required";
} elseif (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters";
} elseif (!preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $password)) {
    $errors[] = "Password must contain uppercase, lowercase, and number";
}

// Return validation errors
if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit();
}

try {
    // Check if email already exists using prepared statement
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists. Please login instead.']);
        $stmt->close();
        exit();
    }
    $stmt->close();
    
    // Hash password securely
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    
    // Insert new user using prepared statement
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $fullName, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        $userId = $stmt->insert_id;
        
        // Set session variables
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $fullName;
        $_SESSION['logged_in'] = true;
        $_SESSION['last_activity'] = time();
        
        echo json_encode(['success' => true, 'message' => 'Signup successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    error_log("Signup error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}

$conn->close();
?>