<?php
session_start();
include 'config.php';
include 'header.php';

// Check if user is logged in and booking ID is provided
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$booking_id = intval($_GET['id']);
$user_id = intval($_SESSION['user_id']);

// Payment status messages
$payment_success = isset($_GET['payment']) && $_GET['payment'] === 'success';
$payment_error = isset($_GET['error']) ? $_GET['error'] : '';

// Price config
$PRICE_CONFIG = [
    'car premium' => ['basePrice' => 100, 'perKm' => 12, 'perPassenger' => 50],
    'auto' => ['basePrice' => 50, 'perKm' => 8, 'perPassenger' => 30],
    'bike' => ['basePrice' => 30, 'perKm' => 6, 'perPassenger' => 20]
];

// Get booking details
$booking_sql = "SELECT * FROM bookings WHERE booking_id = $booking_id AND user_id = $user_id";
$booking_result = $conn->query($booking_sql);

if (!$booking_result || $booking_result->num_rows === 0) {
    die("Booking not found!");
}

$booking = $booking_result->fetch_assoc();

// Get customer name
$user_sql = "SELECT username FROM users WHERE user_id = " . $booking['user_id'];
$user_result = $conn->query($user_sql);
$user_name = ($user_result && $user_result->num_rows > 0) ? 
             $user_result->fetch_assoc()['username'] : 'Guest';
?>

<div class="container mt-5">
    <div class="booking-container">
        <h2 class="text-center mb-4">Booking Confirmation</h2>

        <?php if ($payment_success): ?>
            <div class="alert alert-success text-center">
                Payment proof uploaded successfully! We'll verify your payment shortly.
            </div>
        <?php endif; ?>

        <?php if ($payment_error): ?>
            <div class="alert alert-danger text-center">
                <?php 
                $error_message = match($payment_error) {
                    'upload_failed' => 'Failed to upload payment proof.',
                    'update_failed' => 'Failed to update payment status.',
                    'no_file' => 'No file was uploaded.',
                    default => 'An error occurred.'
                };
                echo $error_message;
                ?>
            </div>
        <?php endif; ?>

        <div class="booking-details">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Booking ID:</strong> #<?php echo $booking['booking_id']; ?></p>
                            <p><strong>Customer:</strong> <?php echo htmlspecialchars($user_name); ?></p>
                            <p><strong>Ride Type:</strong> <?php echo ucfirst($booking['ride_type'] ?? 'car premium'); ?></p>
                            <p><strong>From:</strong> <?php echo $booking['pickup_location']; ?></p>
                            <p><strong>To:</strong> <?php echo $booking['drop_location']; ?></p>
                            <p><strong>Date:</strong> <?php echo date('d M Y', strtotime($booking['booking_date'])); ?></p>
                            <p><strong>Time:</strong> <?php echo date('h:i A', strtotime($booking['booking_time'])); ?></p>
                            <p><strong>Amount:</strong> ₹<?php echo number_format($booking['amount'], 2); ?></p>

                            <div class="payment-section mt-4">
                                <h4 class="text-center">Payment Details</h4>
                                <div class="qr-container text-center">
                                    <img src="img/payment_QR.jpg" alt="Payment QR" class="qr-code">
                                    <p class="mt-3">Scan to pay ₹<?php echo number_format($booking['amount'], 2); ?></p>
                                </div>

                                <form action="verify_manual_payment.php" method="POST" enctype="multipart/form-data" class="mt-4">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
                                    <div class="form-group">
                                        <label for="payment_proof">Upload Payment Screenshot:</label>
                                        <input type="file" class="form-control-file" id="payment_proof" name="payment_proof" accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block mt-3">Verify Payment</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.booking-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.card {
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.qr-code {
    max-width: 200px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.payment-section {
    border-top: 1px solid #eee;
    padding-top: 20px;
}

.form-control-file {
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 5px;
    width: 100%;
}

.btn-primary {
    background-color: #6c5ce7;
    border-color: #6c5ce7;
}

.btn-primary:hover {
    background-color: #5a4bcf;
    border-color: #5a4bcf;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108,92,231,0.2);
}
</style>

<?php include 'footer.php'; ?>
