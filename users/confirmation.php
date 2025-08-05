<?php
session_start();
include 'config.php';

// Check if user is logged in and booking ID exists
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$booking_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$booking_sql = "SELECT * FROM bookings WHERE booking_id = ? AND user_id = ?";
$stmt = $conn->prepare($booking_sql);
$stmt->bind_param("ii", $booking_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Booking not found!";
    exit();
}

$booking = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation - RIDE NOW</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>


<div class="container">
    <div class="confirmation-box">
        <div class="success-icon">
            <img src="img/success.jpg" alt="Success" width="60">
        </div>
        <h2>Payment Successful!</h2>
        <p>Your booking has been confirmed.</p>
        
        <div class="booking-details">
            <h3>Booking Details</h3>
            <div class="detail-row">
                <p><strong>Booking ID:</strong> #<?php echo htmlspecialchars($booking['booking_id']); ?></p>
            </div>
            <div class="detail-row">
                <p><strong>From:</strong> <?php echo htmlspecialchars($booking['pickup_location']); ?></p>
            </div>
            <div class="detail-row">
                <p><strong>To:</strong> <?php echo htmlspecialchars($booking['drop_location']); ?></p>
            </div>
            <div class="detail-row">
                <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($booking['booking_date'])); ?></p>
            </div>
            <div class="detail-row">
                <p><strong>Time:</strong> <?php echo date('h:i A', strtotime($booking['booking_time'])); ?></p>
            </div>
            <div class="detail-row">
                <p><strong>Amount Paid:</strong> ₹<?php echo number_format($booking['amount'], 2); ?></p>
            </div>
        </div>

        <div class="buttons">
            <button onclick="window.location.href='INDEX.php'" class="btn-primary">Go to Dashboard</button>
            <button onclick="window.location.href='book_cab.php'" class="btn-secondary">Book Another Ride</button>
        </div>
    </div>
</div>


<style>
.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 0 20px;
}

.confirmation-box {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    text-align: center;
}

.success-icon {
    margin-bottom: 20px;
}

.booking-details {
    margin: 30px 0;
    text-align: left;
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
}

.detail-row {
    margin: 10px 0;
}

.detail-row p {
    margin: 5px 0;
}

.buttons {
    margin-top: 30px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.btn-primary, .btn-secondary {
    padding: 12px 25px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #6c5ce7;
    color: white;
}

.btn-secondary {
    background: #e0e0e0;
    color: #333;
}

.btn-primary:hover, .btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>

</body>
</html>
