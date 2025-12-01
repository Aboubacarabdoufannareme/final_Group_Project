<?php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: Dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - TaskMasters</title>
  <link rel="stylesheet" href="assets/css/global.css">
  <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>

  <div class="auth-container">
    <!-- Left Side - Branding -->
    <div class="auth-branding">
      <div class="branding-content">
        <a href="index.php" class="brand-logo">
          <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
          TaskMasters
        </a>
        <h1>Join TaskMasters Today!</h1>
        <p>Create your account and start organizing your academic life with ease.</p>
        
        <div class="features-list">
          <div class="feature-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 13l4 4L19 7"/>
            </svg>
            <span>Manage personal tasks</span>
          </div>
          <div class="feature-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 13l4 4L19 7"/>
            </svg>
            <span>Collaborate on group projects</span>
          </div>
          <div class="feature-item">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 13l4 4L19 7"/>
            </svg>
            <span>Track your progress</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Side - Signup Form -->
    <div class="auth-form-container">
      <div class="auth-form-wrapper">
        <div class="auth-header">
          <h2>Create Account</h2>
          <p>Sign up to get started with TaskMasters</p>
        </div>
        
        <div class="auth-info-box">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
            <path d="M14.05 2a9 9 0 018 7.94M14.05 6A5 5 0 0118 10"/>
          </svg>
          <p>Create your account to access Dashboard, Tasks, and Group Projects. It's free and takes less than a minute!</p>
        </div>

        <form id="signupForm" class="auth-form">
          <div class="form-group">
            <label for="fullName" class="form-label">Full Name</label>
            <input 
              type="text" 
              id="fullName" 
              name="fullName" 
              class="form-control" 
              placeholder="Enter your full name" 
              required
            />
          </div>

          <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              class="form-control" 
              placeholder="you@university.edu" 
              required
            />
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              class="form-control" 
              placeholder="Create a strong password" 
              required
            />
          </div>

          <div class="form-group">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input 
              type="password" 
              id="confirmPassword" 
              name="confirmPassword" 
              class="form-control" 
              placeholder="Re-enter your password" 
              required
            />
          </div>

          <div class="form-group">
            <label class="checkbox-label">
              <input type="checkbox" name="terms" required />
              <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
            </label>
          </div>

          <button type="submit" class="btn btn-primary btn-block">
            Create Account
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
          </button>
        </form>

        <div class="auth-footer">
          <p>Already have an account? <a href="Login.php">Sign in</a></p>
        </div>

        <div class="back-home">
          <a href="index.php">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to Home
          </a>
        </div>
      </div>
    </div>
  </div>

  <script src="js/Signup_validation.js"></script>
</body>
</html>
