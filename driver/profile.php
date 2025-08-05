<?php
include '../config.php';

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$msg = '';
$driver_id = $_SESSION['driver_id'];  // You should set this session variable properly

// Fetch driver details
$sql = "SELECT * FROM drivers WHERE driver_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
$driver = $result->fetch_assoc();

if (!$driver) {
    die("Driver not found");
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $vehicle_number = $_POST['vehicle_number'];
    $vehicle_type = $_POST['vehicle_type'];
    $license_number = $_POST['license_number'];
    
    // Handle profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
        $new_filename = 'driver_' . $driver_id . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
                $update_pic = "UPDATE drivers SET profile_pic = ? WHERE driver_id = ?";
                $stmt = $conn->prepare($update_pic);
                $stmt->bind_param("si", $target_file, $driver_id);
                $stmt->execute();
            }
        }
    }

    $update_sql = "UPDATE drivers SET 
                   fullname = ?, 
                   email = ?, 
                   phone = ?, 
                   address = ?,
                   vehicle_number = ?,
                   vehicle_type = ?,
                   license_number = ?
                   WHERE driver_id = ?";

    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssssi", 
        $fullname, 
        $email, 
        $phone, 
        $address, 
        $vehicle_number, 
        $vehicle_type, 
        $license_number, 
        $driver_id
    );

    if ($stmt->execute()) {
        $msg = '<div class="alert alert-success">Profile updated successfully!</div>';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $driver_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $driver = $result->fetch_assoc();
    } else {
        $msg = '<div class="alert alert-danger">Error updating profile</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Driver Profile - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .main-content { padding: 20px; }
        .profile-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .profile-header { text-align: center; margin-bottom: 30px; }
        .profile-pic { 
            width: 150px; 
            height: 150px; 
            border-radius: 50%; 
            object-fit: cover; 
            border: 5px solid #f8f9fa; 
        }
        .form-group { margin-bottom: 20px; }
        .position-relative { display: inline-block; }
        .position-absolute { 
            position: absolute; 
            cursor: pointer; 
        }
    </style>
</head>
<body class="bg-light">
    <div class="main-content">
        <div class="container">

            <!-- Add Back Button -->
            <div class="mb-4">
                <a href="dashboard.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <div class="profile-card">
                <div class="profile-header position-relative">
                    <img src="<?php echo !empty($driver['profile_pic']) ? $driver['profile_pic'] : 'assets/default-profile.jpg'; ?>" 
                         class="profile-pic" alt="Profile Picture">
                    <h2><?php echo htmlspecialchars($driver['fullname']); ?></h2>
                    <p class="text-muted">Driver ID: #<?php echo $driver['driver_id']; ?></p>
                    <a href="edit-profile-pic.php" class="position-absolute" style="top: 10px; right: 10px;">
                        <i class="bi bi-pencil-square" style="font-size: 30px;"></i>
                    </a>
                </div>

                <?php echo $msg; ?>

                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="fullname" value="<?php echo htmlspecialchars($driver['fullname']); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($driver['email']); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($driver['phone']); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($driver['address']); ?>" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Vehicle Number</label>
                            <input type="text" class="form-control" name="vehicle_number" value="<?php echo htmlspecialchars($driver['vehicle_number']); ?>" required>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>Vehicle Type</label>
                            <select class="form-control" name="vehicle_type" required>
                                <option value="car" <?php echo $driver['vehicle_type'] == 'car' ? 'selected' : ''; ?>>Car</option>
                                <option value="bike" <?php echo $driver['vehicle_type'] == 'bike' ? 'selected' : ''; ?>>Bike</option>
                                <option value="auto" <?php echo $driver['vehicle_type'] == 'auto' ? 'selected' : ''; ?>>Auto</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group">
                            <label>License Number</label>
                            <input type="text" class="form-control" name="license_number" value="<?php echo htmlspecialchars($driver['license_number']); ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Profile Picture</label>
                        <input type="file" class="form-control" name="profile_pic" accept="image/*">
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
