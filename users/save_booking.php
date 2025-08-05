<?php
session_start();
include 'config.php';

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in and the form is submitted via POST
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

// Collect form data
$user_id = $_SESSION['user_id'];
$ride_type = $_POST['ride_type'];
$pickup_location = $_POST['pickup_location'];
$drop_location = $_POST['drop_location'];
$date = $_POST['booking_date'];
$time = $_POST['booking_time'];
$passengers = isset($_POST['passengers']) ? intval($_POST['passengers']) : 1;

// Get distance and amount from the correct field names
$distance = isset($_POST['hidden_distance']) ? floatval($_POST['hidden_distance']) : (isset($_POST['distance']) ? floatval($_POST['distance']) : 0);
$total_amount = isset($_POST['hidden_total_amount']) ? floatval($_POST['hidden_total_amount']) : (isset($_POST['amount']) ? floatval($_POST['amount']) : 0);

$status = 'pending';

// Debug logs
error_log("Ride Type: " . $ride_type);
error_log("Distance: " . $distance);
error_log("Amount: " . $total_amount);

// Optional: Add columns if they don't exist (only needed once, remove in production)
$conn->query("ALTER TABLE bookings ADD COLUMN IF NOT EXISTS amount DOUBLE DEFAULT 0");
$conn->query("ALTER TABLE bookings ADD COLUMN IF NOT EXISTS distance DOUBLE DEFAULT 0");
$conn->query("ALTER TABLE bookings ADD COLUMN IF NOT EXISTS status VARCHAR(20) DEFAULT 'pending'");
$conn->query("ALTER TABLE bookings ADD COLUMN IF NOT EXISTS passengers INT DEFAULT 1");

// Prepare and execute insert query
$sql = "INSERT INTO bookings (user_id, ride_type, pickup_location, drop_location, booking_date, booking_time, passengers, distance, amount, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("isssssidds", $user_id, $ride_type, $pickup_location, $drop_location, $date, $time, $passengers, $distance, $total_amount, $status);

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        header("Location: show_booking.php?id=" . $booking_id);
        exit();
    } else {
        error_log("Execute failed: " . $stmt->error);
        echo "Execute failed: " . $stmt->error;
        exit();
    }
} else {
    error_log("Prepare failed: " . $conn->error);
    echo "Prepare failed: " . $conn->error;
    exit();
}

$stmt->close();
$conn->close();
?>
