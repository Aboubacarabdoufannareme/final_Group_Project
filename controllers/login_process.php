<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../config/DBconnection.php'; // adjust path based on folder structure
header('Content-Type: application/json');

// Get and sanitize POST data
$email = sanitize_input($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Please fill all fields']);
    exit();
}

// Prepare statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    exit();
}

$stmt->bind_result($id, $full_name, $password_hash);
$stmt->fetch();

if (password_verify($password, $password_hash)) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $id;
    $_SESSION['full_name'] = $full_name;
    $_SESSION['email'] = $email;

    echo json_encode(['success' => true, 'message' => 'Login successful']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
}

$stmt->close();
close_connection();
exit();
?>
