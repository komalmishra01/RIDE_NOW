<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: drivers.php");
    exit();
}

$driver_id = $_GET['id'];

// Get driver details
$driver_sql = "SELECT * FROM drivers WHERE driver_id = ?";
$stmt = $conn->prepare($driver_sql);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$driver = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Driver Details - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .driver-details {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Driver Details</h2>
                <a href="drivers.php" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Back to Drivers
                </a>
            </div>

            <div class="driver-details">
                <div class="text-center">
                    <img src="<?php echo !empty($driver['profile_pic']) ? '../' . $driver['profile_pic'] : '../assets/default-profile.jpg'; ?>" 
                         class="profile-pic" alt="Driver Profile">
                </div>
                <h4>Personal Information</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($driver['fullname']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($driver['email']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($driver['phone']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Vehicle Type:</strong> <?php echo ucfirst($driver['vehicle_type']); ?></p>
                        <p><strong>Vehicle Number:</strong> <?php echo htmlspecialchars($driver['vehicle_number']); ?></p>
                        <p><strong>License Number:</strong> <?php echo htmlspecialchars($driver['license_number']); ?></p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-<?php echo $driver['status'] == 'active' ? 'success' : 'danger'; ?>">
                                <?php echo ucfirst($driver['status']); ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
