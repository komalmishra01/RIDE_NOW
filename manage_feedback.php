<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch feedback with user details from correct table
$sql = "SELECT f.*, u.fullname as user_name 
        FROM ridenowdbt.feedback f 
        LEFT JOIN ridenowdbt.users u ON f.user_id = u.user_id 
        ORDER BY f.created_at DESC";
$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}

// Calculate average rating
$avg_sql = "SELECT AVG(rating) as avg_rating FROM ridenowdbt.feedback";
$avg_result = $conn->query($avg_sql);
$avg_rating = ($avg_result && $row = $avg_result->fetch_assoc()) ? $row['avg_rating'] : 0;?>

<!DOCTYPE html>
<html>
<head>
    <title>User Feedback - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        .feedback-card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .feedback-header {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .rating-stars {
            color: #ffc107;
        }
        .stats-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        .avg-rating {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">User Feedback</h2>

            <!-- Stats Section -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <h5>Average Rating</h5>
                        <div class="avg-rating">
                            <?php echo number_format($avg_rating, 1); ?> / 5.0
                            <div class="rating-stars">
                                <?php
                                $full_stars = floor($avg_rating);
                                $half_star = ($avg_rating - $full_stars) >= 0.5;

                                for ($i = 0; $i < $full_stars; $i++) {
                                    echo '<i class="bx bxs-star"></i>';
                                }
                                if ($half_star) {
                                    echo '<i class="bx bxs-star-half"></i>';
                                }
                                for ($i = 0; $i < (5 - $full_stars - ($half_star ? 1 : 0)); $i++) {
                                    echo '<i class="bx bx-star"></i>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback List -->
            <?php if ($result->num_rows > 0): ?>
                <?php while($feedback = $result->fetch_assoc()): ?>
                    <div class="feedback-card bg-white">
                        <div class="feedback-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0"><?php echo htmlspecialchars($feedback['user_name'] ?? 'Anonymous'); ?></h5>
                                <small class="text-muted">
                                    <?php echo date('M d, Y H:i', strtotime($feedback['created_at'])); ?>
                                </small>
                            </div>
                            <div class="rating-stars">
                                <?php
                                $user_rating = (int)$feedback['rating'];
                                for ($i = 0; $i < $user_rating; $i++) {
                                    echo '<i class="bx bxs-star"></i>';
                                }
                                for ($i = $user_rating; $i < 5; $i++) {
                                    echo '<i class="bx bx-star"></i>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($feedback['comment'])); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="alert alert-info">No feedback found.</div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
