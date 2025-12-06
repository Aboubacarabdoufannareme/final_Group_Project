<?php
session_start();
require_once __DIR__ . '../config/DBconnection.php'; // adjust path based on folder structure


// If already logged in, redirect
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: Dashboard.php");
    exit();
}

$message = $_GET['message'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - TaskMasters</title>
  <link rel="stylesheet" href="assets/css/global.css">
  <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
  <div class="auth-container">
    <!-- Your branding HTML here -->
    <div class="auth-form-container">
      <div class="auth-form-wrapper">
        <form id="loginForm" class="auth-form">
          <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="you@university.edu" required />
          </div>
          <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required />
          </div>
          <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        </form>
      </div>
    </div>
  </div>

  <script src="js/login_validation_fixed.js"></script>
</body>
</html>
