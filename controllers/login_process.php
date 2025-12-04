<?php

header('Content-Type: application/json');
session_start();

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'webtech_20205A_fannareme_abdou';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($email === '' || $password === '') {
    echo json_encode(['success' => false, 'message' => 'Please fill all fields']);
    exit();
}

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    echo json_encode(['success' => false, 'message' => 'Database connection error']);
    exit();
}

$stmt = $mysqli->prepare("SELECT id, full_name, password FROM users WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    $stmt->close();
    $mysqli->close();
    exit();
}

$stmt->bind_result($id, $full_name, $password_hash);
$stmt->fetch();

if (password_verify($password, $password_hash) || $password === $password_hash) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $id;
    $_SESSION['user_name'] = $full_name;
    $stmt->close();
    $mysqli->close();
    echo json_encode(['success' => true, 'message' => 'Login successful']);
    exit();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
}
$stmt->close();
$mysqli->close();
?>