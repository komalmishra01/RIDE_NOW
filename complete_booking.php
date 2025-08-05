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
        header("Location: dashboard.php?msg=completed");
    } else {
        header("Location: dashboard.php?error=1");
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
        header("Location: dashboard.php?msg=cancelled");
    } else {
        header("Location: dashboard.php?error=1");
    }
    exit();
}

// Fetch stats and bookings (same as your original code)
// Booking stats
$stats = [
    'total_revenue' => 0,
    'complete_rides' => 0,
    'cancelled_rides' => 0,
    'total_rides' => 0,
    'total_users' => 0
];

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

$user_sql = "SELECT COUNT(*) as total_users FROM users";
$user_result = $conn->query($user_sql);
if ($user_result && $user_result->num_rows > 0) {
    $stats['total_users'] = $user_result->fetch_assoc()['total_users'];
}

// Recent bookings
$recent_bookings = [];
$recent_bookings_sql = "SELECT b.*, u.fullname as username 
    FROM bookings b 
    LEFT JOIN users u ON b.user_id = u.user_id 
    ORDER BY b.booking_id DESC LIMIT 5";
$recent_result = $conn->query($recent_bookings_sql);
if ($recent_result && $recent_result->num_rows > 0) {
    while ($row = $recent_result->fetch_assoc()) {
        $recent_bookings[] = $row;
    }
}
?>

<!-- HTML Section (Just showing the relevant row part here) -->
<td>
    <?php if($booking['status'] == 'confirmed'): ?>
        <a href="dashboard.php?complete_id=<?php echo $booking['booking_id']; ?>" 
           class="btn btn-sm btn-success"
           onclick="return confirm('Mark this ride as completed?')">
            Complete
        </a>
    <?php elseif($booking['status'] == 'pending'): ?>
        <a href="dashboard.php?cancel_id=<?php echo $booking['booking_id']; ?>" 
           class="btn btn-sm btn-danger"
           onclick="return confirm('Are you sure you want to cancel this booking?')">
            Cancel
        </a>
    <?php else: ?>
        <span class="text-muted">-</span>
    <?php endif; ?>
</td>
