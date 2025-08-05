<?php
session_start();
include '../config.php';

// Check if driver is logged in
if (!isset($_SESSION['driver_id'])) {
    http_response_code(401);
    exit('Unauthorized');
}

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);
$booking_id = $data['booking_id'];
$driver_id = $_SESSION['driver_id'];

// Update booking status
$sql = "UPDATE bookings SET status = 'confirmed', driver_id = ? WHERE booking_id = ? AND status = 'pending'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $driver_id, $booking_id);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conn->error]);
}