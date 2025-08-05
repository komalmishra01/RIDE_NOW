<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['reset_email'])) {
        header("Location: forgot_password.php");
        exit();
    }

    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_SESSION['reset_email'];

    // Validate passwords
    if ($new_password !== $confirm_password) {
        header("Location: reset_password.php?error=password_mismatch");
        exit();
    }

    // Password strength validation
    if (strlen($new_password) < 6 || !preg_match("/[A-Z]/", $new_password) || !preg_match("/[0-9]/", $new_password)) {
        header("Location: reset_password.php?error=weak_password");
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in database
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        header("Location: reset_password.php?error=db_error");
        exit();
    }

    $stmt->bind_param("ss", $hashed_password, $email);
    
    if ($stmt->execute()) {
        // Clear all session variables
        unset($_SESSION['reset_otp']);
        unset($_SESSION['reset_email']);
        unset($_SESSION['otp_time']);
        
        // Redirect to login with success message
        header("Location: login.php?success=password_updated");
    } else {
        header("Location: reset_password.php?error=update_failed");
    }
    exit();
} else {
    header("Location: forgot_password.php");
    exit();
}
?>