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

// Delete the driver from driver_drive table instead of drivers
$sql = "DELETE FROM driver_drive WHERE driver_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);

if ($stmt->execute()) {
    header("Location: drivers.php?msg=deleted");
} else {
    header("Location: drivers.php?msg=delete_failed");
}

exit();