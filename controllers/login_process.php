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

// Get and validate inputs
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Server-side validation
$errors = [];

if (empty($email)) {
    $errors[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

if (empty($password)) {
    $errors[] = "Password is required";
}

// Return validation errors
if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit();
}

try {
    // Fetch user using prepared statement
    $stmt = $conn->prepare("SELECT id, full_name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        $stmt->close();
        exit();
    }
    
    $user = $result->fetch_assoc();
    $stmt->close();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['logged_in'] = true;
        $_SESSION['last_activity'] = time();
        
        // Update last login
        $updateStmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $updateStmt->bind_param("i", $user['id']);
        $updateStmt->execute();
        $updateStmt->close();
        
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }
    
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}

$conn->close();
?>