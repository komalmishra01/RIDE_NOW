<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch all drivers
$sql = "SELECT * FROM drivers ORDER BY driver_id DESC";
$result = $conn->query($sql);

// Handle status toggle if requested
if (isset($_GET['toggle_id']) && isset($_GET['status'])) {
    $driver_id = $_GET['toggle_id'];
    $new_status = $_GET['status'];
    
    $update_sql = "UPDATE drivers SET status = ? WHERE driver_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $new_status, $driver_id);
    
    if ($stmt->execute()) {
        header("Location: drivers.php?msg=status_updated");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Drivers - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/dynamic_styles.php">    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .drivers-table {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .status-badge {
            cursor: pointer;
        }
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Manage Drivers</h2>
                <a href="add_driver.php" class="btn btn-primary">
                    <i class='bx bx-plus'></i> Add New Driver
                </a>
            </div>

            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php 
                    switch($_GET['msg']) {
                        case 'added':
                            echo "Driver added successfully!";
                            break;
                        case 'updated':
                            echo "Driver updated successfully!";
                            break;
                        case 'deleted':
                            echo "Driver deleted successfully!";
                            break;
                        case 'status_updated':
                            echo "Driver status updated successfully!";
                            break;
                    }
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="drivers-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Vehicle Type</th>
                            <th>Vehicle Number</th>
                            <th>License Number</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($driver = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $driver['driver_id']; ?></td>
                                    <td>
                                        <img src="<?php echo !empty($driver['profile_pic']) ? '../' . $driver['profile_pic'] : '../assets/default-profile.jpg'; ?>" 
                                             class="profile-pic" alt="Profile">
                                    </td>
                                    <td><?php echo htmlspecialchars($driver['fullname']); ?></td>
                                    <td><?php echo htmlspecialchars($driver['email']); ?></td>
                                    <td><?php echo htmlspecialchars($driver['phone']); ?></td>
                                    <td><?php echo ucfirst($driver['vehicle_type']); ?></td>
                                    <td><?php echo htmlspecialchars($driver['vehicle_number']); ?></td>
                                    <td><?php echo htmlspecialchars($driver['license_number']); ?></td>
                                    <td>
                                      <?php 
                                           $status = isset($driver['status']) ? $driver['status'] : 'active';
                                           $statusClass = ($status == 'active') ? 'success' : 'danger';
                                        ?>
                                          <a href="drivers.php?toggle_id=<?php echo $driver['driver_id']; ?>&status=<?php echo $status == 'active' ? 'inactive' : 'active'; ?>" 
                                           class="badge bg-<?php echo $statusClass; ?> status-badge">
                                       <?php echo ucfirst($status); ?>
                                          </a>
                                    </td>
                                    <td>
                                        <a href="edit_driver.php?id=<?php echo $driver['driver_id']; ?>" 
                                           class="btn btn-sm btn-warning">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger delete-driver" 
                                                data-id="<?php echo $driver['driver_id']; ?>">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </td>
                                    <td>
                                       <a href="view_driver.php?id=<?php echo $driver['driver_id']; ?>" 
                                          class="btn btn-sm btn-info">
                                          <i class='bx bx-show'></i>
                                       </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">No drivers found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.delete-driver').forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to delete this driver?')) {
                    const driverId = this.dataset.id;
                    window.location.href = `delete_driver.php?id=${driverId}`;
                }
            });
        });
    </script>
</body>
</html>
