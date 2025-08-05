<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Get current status
    $status_sql = "SELECT status FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($status_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    // Toggle status
    $new_status = $user['status'] ? 0 : 1;
    
    // Update status
    $update_sql = "UPDATE users SET status = ? WHERE user_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ii", $new_status, $user_id);
    
    if ($stmt->execute()) {
        header("Location: users.php?msg=" . ($new_status ? 'activated' : 'deactivated'));
    } else {
        header("Location: users.php?error=1");
    }
} else {
    header("Location: users.php");
}
exit(); 
