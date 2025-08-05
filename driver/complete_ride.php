<?php
session_start();
include '../config.php';

if (!isset($_SESSION['driver_id'])) {
    http_response_code(401);
    exit('Unauthorized');
}

$data = json_decode(file_get_contents('php://input'), true);
$booking_id = $data['booking_id'];
$driver_id = $_SESSION['driver_id'];

$sql = "UPDATE bookings SET status = 'completed' WHERE booking_id = ? AND driver_id = ? AND status = 'confirmed'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $booking_id, $driver_id);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $conn->error]);
}