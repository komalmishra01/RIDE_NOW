<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch form inputs with fallback
    $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $vehicle_type = isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] : '';
    $vehicle_number = isset($_POST['vehicle_number']) ? $_POST['vehicle_number'] : '';
    $license_number = isset($_POST['license_number']) ? $_POST['license_number'] : '';
    $status = 'active';

    // Handle profile picture upload
    $profile_pic = '';
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "../uploads/drivers/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_extension = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
            $profile_pic = 'uploads/drivers/' . $file_name;
        }
    }

    // Insert into database
    $sql = "INSERT INTO drivers (fullname, email, phone, vehicle_type, vehicle_number, license_number, profile_pic, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error in preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssssssss", $fullname, $email, $phone, $vehicle_type, $vehicle_number, $license_number, $profile_pic, $status);

    if ($stmt->execute()) {
        header("Location: drivers.php?msg=added");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Driver - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .form-container {
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
            <h2 class="mb-4">Add New Driver</h2>

            <div class="form-container">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" name="profile_pic" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="fullname" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vehicle Type</label>
                        <select class="form-select" name="vehicle_type" required>
                            <option value="car">Car</option>
                            <option value="auto">Auto</option>
                            <option value="bike">Bike</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Vehicle Number</label>
                        <input type="text" class="form-control" name="vehicle_number" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">License Number</label>
                        <input type="text" class="form-control" name="license_number" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Driver</button>
                    <a href="drivers.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
