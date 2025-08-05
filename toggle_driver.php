<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: drivers.php");
    exit();
}

$driver_id = $_GET['id'];

// Get current status
$sql = "SELECT status FROM driver_drive WHERE driver_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
$driver = $result->fetch_assoc();

if ($driver) {
    // Toggle the status between 'active' and 'inactive'
    $current_status = strtolower($driver['status']);
    $new_status = $current_status === 'active' ? 'inactive' : 'active';

    // Update the status
    $update_sql = "UPDATE driver_drive SET status = ? WHERE driver_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $new_status, $driver_id);

    if ($update_stmt->execute()) {
        header("Location: drivers.php?msg=status_updated");
    } else {
        header("Location: drivers.php?msg=update_failed");
    }
} else {
    header("Location: drivers.php?msg=driver_not_found");
}

exit();
