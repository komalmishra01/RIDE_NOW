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

// Fetch driver details from the correct table
$sql = "SELECT * FROM drivers WHERE driver_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$driver = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $vehicle_number = $_POST['vehicle_number'];
    $vehicle_type = $_POST['vehicle_type'];

    // Update query for the drivers table
    $update_sql = "UPDATE drivers SET fullname = ?, phone = ?, vehicle_number = ?, vehicle_type = ? WHERE driver_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $fullname, $phone, $vehicle_number, $vehicle_type, $driver_id);

    if ($update_stmt->execute()) {
        header("Location: drivers.php?msg=updated");
        exit();
    } else {
        $error = "Failed to update driver.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Driver - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit Driver</h2>
                <a href="drivers.php" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Back to Drivers
                </a>
            </div>

            <div class="form-container">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="fullname" class="form-control" 
                               value="<?php echo htmlspecialchars($driver['fullname']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-control" 
                               value="<?php echo htmlspecialchars($driver['phone']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vehicle Number</label>
                        <input type="text" name="vehicle_number" class="form-control" 
                               value="<?php echo htmlspecialchars($driver['vehicle_number']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vehicle Type</label>
                        <select name="vehicle_type" class="form-control" required>
                            <option value="">Select Vehicle Type</option>
                            <option value="bike" <?php echo $driver['vehicle_type'] == 'bike' ? 'selected' : ''; ?>>Bike</option>
                            <option value="auto" <?php echo $driver['vehicle_type'] == 'auto' ? 'selected' : ''; ?>>Auto</option>
                            <option value="car" <?php echo $driver['vehicle_type'] == 'car' ? 'selected' : ''; ?>>Car</option>
                            <option value="car premium" <?php echo $driver['vehicle_type'] == 'car premium' ? 'selected' : ''; ?>>Car Premium</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Driver</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
