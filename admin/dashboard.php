<head>
    <title>Admin Dashboard - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/dynamic_styles.php">
</head>
<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
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
    header("Location: dashboard.php?msg=completed");
    exit();
}

// Handle ride cancellation
if (isset($_GET['cancel_id'])) {
    $booking_id = $_GET['cancel_id'];
    $sql = "UPDATE bookings SET status = 'cancelled' WHERE booking_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    header("Location: dashboard.php?msg=cancelled");
    exit();
}

// Initialize statistics
$stats = [
    'total_revenue' => 0,
    'complete_rides' => 0,
    'cancelled_rides' => 0,
    'total_rides' => 0,
    'total_users' => 0
];

// Booking stats
$sql = "SELECT 
    COUNT(*) as total_rides,
    SUM(amount) as total_revenue,
    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as complete_rides,
    SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled_rides
    FROM bookings";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $stats = array_merge($stats, $result->fetch_assoc());
}

// User count
$user_sql = "SELECT COUNT(*) as total_users FROM users";
$user_result = $conn->query($user_sql);
if ($user_result && $user_result->num_rows > 0) {
    $stats['total_users'] = $user_result->fetch_assoc()['total_users'];
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
    <title>Admin Dashboard - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        .stats-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .stats-card i {
            font-size: 2.5rem;
            color: #6c5ce7;
        }
        .stats-card h3 {
            margin: 15px 0;
            color: #2d3436;
        }
        .stats-card p {
            color: #636e72;
            margin: 0;
        }
        .recent-bookings {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Dashboard</h2>

            <div class="row">
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class='bx bx-money'></i>
                        <h3>₹<?php echo number_format($stats['total_revenue'], 2); ?></h3>
                        <p>Total Revenue</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class='bx bx-check-circle'></i>
                        <h3><?php echo $stats['complete_rides']; ?></h3>
                        <p>Completed Rides</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class='bx bx-x-circle'></i>
                        <h3><?php echo $stats['cancelled_rides']; ?></h3>
                        <p>Cancelled Rides</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <i class='bx bx-user'></i>
                        <h3><?php echo $stats['total_users']; ?></h3>
                        <p>Total Users</p>
                    </div>
                </div>
            </div>

            <div class="recent-bookings mt-4">
                <h4>Recent Bookings</h4>
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
                                            <a href="dashboard.php?complete_id=<?php echo $booking['booking_id']; ?>" 
                                               class="btn btn-success btn-sm"
                                               onclick="return confirm('Mark this ride as completed?')">
                                                Complete
                                            </a>
                                        <?php endif; ?>

                                        <?php if($booking['status'] == 'pending'): ?>
                                            <a href="dashboard.php?cancel_id=<?php echo $booking['booking_id']; ?>" 
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
