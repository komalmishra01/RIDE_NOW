<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch all contact messages with correct table name
$sql = "SELECT * FROM ridenowdbt.contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);

// Check if query was successful
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Messages - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        .message-card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .message-header {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .message-body {
            padding: 20px;
        }
        .status-badge {
            float: right;
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Contact Messages</h2>

            <?php if ($result->num_rows > 0): ?>
                <?php while($message = $result->fetch_assoc()): ?>
                    <div class="message-card bg-white">
                        <div class="message-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0"><?php echo htmlspecialchars($message['name']); ?></h5>
                                <small class="text-muted">
                                    <?php echo htmlspecialchars($message['email']); ?> | 
                                    <?php echo date('M d, Y H:i', strtotime($message['created_at'])); ?>
                                </small>
                            </div>
                            <!-- Show phone number in badge -->
                            <span class="badge bg-primary"><?php echo htmlspecialchars($message['email']); ?></span>
                        </div>
                        <div class="message-body">
                            <p class="mb-0"><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info">No contact messages found.</div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
