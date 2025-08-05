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
    $sql = "UPDATE bookings SET status = 'completed' WHERE booking_id = ? AND status = 'confirmed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        header("Location: manage_bookings.php?msg=completed");
    } else {
        header("Location: manage_bookings.php?error=1");
    }
    exit();
}

// Handle ride cancellation
if (isset($_GET['cancel_id'])) {
    $booking_id = $_GET['cancel_id'];
    $sql = "UPDATE bookings SET status = 'cancelled' WHERE booking_id = ? AND status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        header("Location: manage_bookings.php?msg=cancelled");
    } else {
        header("Location: manage_bookings.php?error=1");
    }
    exit();
}

// Fetch all bookings
$bookings_sql = "SELECT b.*, u.fullname as username 
                 FROM bookings b 
                 LEFT JOIN users u ON b.user_id = u.user_id 
                 ORDER BY b.booking_id DESC";
$result = $conn->query($bookings_sql);

$bookings = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/dynamic_styles.php">    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .bookings-table {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        .badge {
            font-size: 0.85em;
            padding: 0.5em 0.75em;
        }
        .btn-sm {
            margin: 0 2px;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Manage Bookings</h2>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Ride <?php echo htmlspecialchars($_GET['msg']); ?> successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Something went wrong. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="bookings-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Ride Type</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bookings)): ?>
                            <?php foreach($bookings as $booking): ?>
                                <tr>
                                    <td>#<?php echo $booking['booking_id']; ?></td>
                                    <td><?php echo htmlspecialchars($booking['username'] ?? 'Guest'); ?></td>
                                    <td><?php echo $booking['ride_type']; ?></td>
                                    <td><?php echo $booking['pickup_location']; ?></td>
                                    <td><?php echo $booking['drop_location']; ?></td>
                                    <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></td>
                                    <td>₹<?php echo number_format($booking['amount'], 2); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $booking['status'] == 'completed' ? 'success' : 
                                            ($booking['status'] == 'cancelled' ? 'danger' : 'warning'); ?>">
                                            <?php echo ucfirst($booking['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($booking['status'] == 'confirmed'): ?>
                                            <a href="manage_bookings.php?complete_id=<?php echo $booking['booking_id']; ?>" 
                                               class="btn btn-sm btn-success"
                                               onclick="return confirm('Mark this ride as completed?')">
                                                Complete
                                            </a>
                                        <?php elseif($booking['status'] == 'pending'): ?>
                                            <a href="manage_bookings.php?cancel_id=<?php echo $booking['booking_id']; ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                Cancel
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-muted">No bookings found.</td>
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
