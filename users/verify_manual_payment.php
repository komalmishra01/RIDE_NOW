<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['booking_id'])) {
    header("Location: login.php");
    exit();
}

$booking_id = intval($_POST['booking_id']);
$user_id = $_SESSION['user_id'];

// Handle file upload
if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] == 0) {
    $target_dir = "uploads/payments/";
    $file_extension = pathinfo($_FILES["payment_proof"]["name"], PATHINFO_EXTENSION);
    $file_name = "payment_" . $booking_id . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file)) {
        // Update booking status and payment proof in database
        $sql = "UPDATE bookings SET status = 'confirmed', payment_proof = ? WHERE booking_id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $file_name, $booking_id, $user_id);
        
        if ($stmt->execute()) {
            header("Location: confirmation.php?id=" . $booking_id);
            exit();
        } else {
            header("Location: show_booking.php?id=" . $booking_id . "&error=update_failed");
            exit();
        }
    } else {
        header("Location: show_booking.php?id=" . $booking_id . "&error=upload_failed");
        exit();
    }
} else {
    header("Location: show_booking.php?id=" . $booking_id . "&error=no_file");
    exit();
}
?>