<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'header.php';

// Fetch user's bookings
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM bookings WHERE user_id = ? ORDER BY booking_date DESC, booking_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .booking-container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
    }

    .booking-header {
        text-align: center;
        background: linear-gradient(135deg, #2c3e50, #3498db);
        padding: 40px 20px;
        border-radius: 15px;
        margin-bottom: 30px;
        color: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .booking-header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .booking-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        padding: 20px 0;
    }

    .booking-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .ride-status {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 15px;
        text-transform: capitalize;
    }

    .status-active {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .status-completed {
        background: #e3f2fd;
        color: #1565c0;
    }

    .status-cancelled {
        background: #ffebee;
        color: #c62828;
    }

    .ride-info {
        margin-bottom: 20px;
    }

    .info-row {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .info-row i {
        width: 30px;
        color: #666;
        margin-right: 10px;
    }

    .location-dot {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .pickup-dot {
        background: #4CAF50;
    }

    .drop-dot {
        background: #f44336;
    }

    .ride-price {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c3e50;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .empty-state {
        text-align: center;
        padding: 50px 20px;
        background: #f8f9fa;
        border-radius: 15px;
        margin: 20px 0;
    }

    .empty-state i {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #666;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #999;
    }
</style>

<div class="booking-container">
    <div class="booking-header">
        <h1>My Bookings</h1>
        <p>View and manage your ride history</p>
    </div>

    <div class="booking-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while($booking = $result->fetch_assoc()): ?>
                <div class="booking-card">
                    <span class="ride-status status-<?php echo strtolower($booking['status']); ?>">
                        <?php echo ucfirst($booking['status']); ?>
                    </span>
                    <div class="ride-info">
                        <div class="info-row">
                            <i class="fas fa-calendar"></i>
                            <span><?php echo date('M d, h:i A', strtotime($booking['booking_date'] . ' ' . $booking['booking_time'])); ?></span>
                        </div>
                        <div class="info-row">
                            <i class="fas fa-circle pickup-dot"></i>
                            <span><?php echo htmlspecialchars($booking['pickup_location']); ?></span>
                        </div>
                        <div class="info-row">
                            <i class="fas fa-circle drop-dot"></i>
                            <span><?php echo htmlspecialchars($booking['drop_location']); ?></span>
                        </div>
                        <div class="info-row">
                            <i class="fas fa-car"></i>
                            <span><?php echo ucfirst($booking['ride_type']); ?></span>
                        </div>
                    </div>
                    <div class="ride-price">
                        ₹<?php echo number_format($booking['amount'], 2); ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-car"></i>
                <h3>No bookings yet</h3>
                <p>Your booking history will appear here</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
