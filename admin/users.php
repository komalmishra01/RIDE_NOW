<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch all users
$users_sql = "SELECT * FROM users ORDER BY user_id DESC";
$result = $conn->query($users_sql);

$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/dynamic_styles.php">    <style>
        .users-table {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .table th {
            background-color: #f8f9fa;
        }
        .status-active {
            color: #28a745;
        }
        .status-inactive {
            color: #dc3545;
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Manage Users</h2>

            <div class="users-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Total Rides</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                            <tr>
                                <td>#<?php echo $user['user_id']; ?></td>
                                <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                <td>
                                    <?php 
                                    $rides_sql = "SELECT COUNT(*) as total FROM bookings WHERE user_id = " . $user['user_id'];
                                    $rides_result = $conn->query($rides_sql);
                                    $rides = $rides_result->fetch_assoc();
                                    echo $rides['total'];
                                    ?>
                                </td>
                                <td>
                                    <span class="status-<?php echo $user['status'] ? 'active' : 'inactive'; ?>">
                                        <i class='bx bxs-circle'></i>
                                        <?php echo $user['status'] ? 'Active' : 'Inactive'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="view_user.php?id=<?php echo $user['user_id']; ?>" 
                                       class="btn btn-sm btn-info">
                                        <i class='bx bxs-user-detail'></i>
                                    </a>
                                    <a href="toggle_user.php?id=<?php echo $user['user_id']; ?>" 
                                       class="btn btn-sm <?php echo $user['status'] ? 'btn-warning' : 'btn-success'; ?>"
                                       onclick="return confirm('Are you sure you want to <?php echo $user['status'] ? 'deactivate' : 'activate'; ?> this user?')">
                                        <i class='bx bxs-<?php echo $user['status'] ? 'user-x' : 'user-check'; ?>'></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
