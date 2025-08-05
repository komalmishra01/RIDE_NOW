<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    
    $sql = "UPDATE bookings SET status = 'cancelled' WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=cancelled");
    } else {
        header("Location: dashboard.php?error=1");
    }
} else {
    header("Location: dashboard.php");
}
exit();