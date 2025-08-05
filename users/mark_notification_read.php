<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['notification_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$user_id = $_SESSION['user_id'];
$notification_id = $_POST['notification_id'];

$sql = "UPDATE notifications SET is_read = 1 
        WHERE notification_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $notification_id, $user_id);

echo json_encode(['success' => $stmt->execute()]);