<?php
session_start();
include '../config.php';

if (!isset($_SESSION['driver_id'])) {
    header("Location: index.php");
    exit();
}

// Handle ride completion
if (isset($_GET['complete_id'])) {
    $booking_id = $_GET['complete_id'];
    $sql = "UPDATE bookings SET status = 'completed' WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    header("Location: earnings.php?msg=completed");
    exit();
}

// Handle ride cancellation
if (isset($_GET['cancel_id'])) {
    $booking_id = $_GET['cancel_id'];
    $sql = "UPDATE bookings SET status = 'cancelled' WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    header("Location: earnings.php?msg=cancelled");
    exit();
}

// Initialize statistics
$stats = [
    'total_revenue' => 0
];

// Booking stats
$sql = "SELECT SUM(amount) as total_revenue FROM bookings WHERE status = 'completed'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stats['total_revenue'] = $row['total_revenue'] ?? 0;
}

// Recent bookings
$recent_bookings_sql = "SELECT b.*, u.fullname as username 
                       FROM bookings b 
                       LEFT JOIN users u ON b.user_id = u.user_id 
                       ORDER BY b.booking_id DESC LIMIT 5";
$recent_result = $conn->query($recent_bookings_sql);

$recent_bookings = [];
if ($recent_result && $recent_result->num_rows > 0) {
    while ($row = $recent_result->fetch_assoc()) {
        $recent_bookings[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Driver Earnings - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .stats-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .stats-card i {
            font-size: 3rem;
            color: #2ecc71;
            margin-bottom: 15px;
        }
        .stats-card h3 {
            margin: 15px 0;
            color: #2d3436;
            font-size: 28px;
            font-weight: 600;
        }
        .stats-card p {
            color: #636e72;
            margin: 0;
            font-size: 16px;
            font-weight: 500;
        }
        .recent-bookings {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        .recent-bookings h4 {
            color: #2d3436;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #2d3436;
            font-weight: 600;
            padding: 12px;
        }
        .table tbody td {
            padding: 12px;
            vertical-align: middle;
        }
        .badge {
            padding: 8px 12px;
            font-weight: 500;
        }
        .btn-sm {
            padding: 5px 15px;
            font-weight: 500;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            .stats-card {
                margin-bottom: 15px;
            }
            .table-responsive {
                border-radius: 15px;
            }
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Earnings</h2>

            <div class="row">
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class='bx bx-money'></i>
                        <h3>₹<?php echo number_format($stats['total_revenue'], 2); ?></h3>
                        <p>Total Revenue</p>
                    </div>
                </div>
            </div>

            <div class="recent-bookings mt-4">
                <h4>Recent Bookings</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recent_bookings)): ?>
                                <?php foreach($recent_bookings as $booking): ?>
                                    <tr>
                                        <td>#<?php echo $booking['booking_id']; ?></td>
                                        <td><?php echo htmlspecialchars($booking['username'] ?? 'Guest'); ?></td>
                                        <td><?php echo $booking['pickup_location']; ?></td>
                                        <td><?php echo $booking['drop_location']; ?></td>
                                        <td>₹<?php echo number_format($booking['amount'], 2); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $booking['status'] == 'completed' ? 'success' : 
                                                ($booking['status'] == 'cancelled' ? 'danger' : 'warning'); ?>">
                                                <?php echo ucfirst($booking['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($booking['status'] == 'confirmed'): ?>
                                                <a href="earnings.php?complete_id=<?php echo $booking['booking_id']; ?>" 
                                                   class="btn btn-success btn-sm"
                                                   onclick="return confirm('Mark this ride as completed?')">
                                                    Complete
                                                </a>
                                            <?php endif; ?>

                                            <?php if($booking['status'] == 'pending'): ?>
                                                <a href="earnings.php?cancel_id=<?php echo $booking['booking_id']; ?>" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                    Cancel
                                                </a>
                                            <?php endif; ?>

                                            <?php if($booking['status'] != 'confirmed' && $booking['status'] != 'pending'): ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No recent bookings found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
