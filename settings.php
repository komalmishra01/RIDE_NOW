<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}


// Add default logo to site_settings
$logo_sql = "INSERT INTO site_settings (setting_name, setting_value) 
             VALUES ('logo_url', 'uploads/default_logo.png')
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";
$conn->query($logo_sql);


// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['rates'])) {
        $success = true;
        foreach ($_POST['rates'] as $vehicle_type => $rates) {
            // Validate and sanitize inputs
            $base_price = floatval($rates['base_price']);
            $per_km = floatval($rates['per_km']);
            $per_passenger = floatval($rates['per_passenger']);

            // Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['rates'])) {
        $success = true;
        $price_changes = [];
        
        foreach ($_POST['rates'] as $vehicle_type => $rates) {
            // Validate and sanitize inputs
            $base_price = floatval($rates['base_price']);
            $per_km = floatval($rates['per_km']);
            $per_passenger = floatval($rates['per_passenger']);
            
// Get current rates to check for changes
$check_sql = "SELECT base_price, per_km, per_passenger FROM admin_vehicle_rates WHERE vehicle_type = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $vehicle_type);
$check_stmt->execute();
$old_rates = $check_stmt->get_result()->fetch_assoc();

// Check if prices have changed
if ($old_rates['base_price'] != $base_price || 
    $old_rates['per_km'] != $per_km || 
    $old_rates['per_passenger'] != $per_passenger) {
    $price_changes[] = [
        'vehicle_type' => $vehicle_type,
        'old_base' => $old_rates['base_price'],
        'new_base' => $base_price,
        'old_km' => $old_rates['per_km'],
        'new_km' => $per_km,
        'old_passenger' => $old_rates['per_passenger'],
        'new_passenger' => $per_passenger
    ];
}            
            $update_sql = "UPDATE admin_vehicle_rates SET 
                          base_price = ?, 
                          per_km = ?, 
                          per_passenger = ? 
                          WHERE vehicle_type = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("ddds", $base_price, $per_km, $per_passenger, $vehicle_type);
            
            if (!$stmt->execute()) {
                $error = "Failed to update rates for " . ucfirst($vehicle_type);
                $success = false;
                break;
            }
        }

        if ($success && !empty($price_changes)) {
            // Create notification message
            $notification_message = "Price Updates:\n";
            foreach ($price_changes as $change) {
                $vehicle = ucfirst($change['vehicle_type']);
                $notification_message .= "$vehicle: Base price updated from ₹{$change['old_base']} to ₹{$change['new_base']}, ";
                $notification_message .= "Per KM rate updated from ₹{$change['old_km']} to ₹{$change['new_km']}";
                if ($change['old_passenger'] != $change['new_passenger']) {
                    $notification_message .= ", Per passenger rate updated from ₹{$change['old_passenger']} to ₹{$change['new_passenger']}";
                }
                $notification_message .= "\n";
            }
            
            // Insert notification for all users
            $notify_sql = "INSERT INTO notifications (user_id, message, type) 
                          SELECT user_id, ?, 'price_update' FROM users";
            $notify_stmt = $conn->prepare($notify_sql);
            $notify_stmt->bind_param("s", $notification_message);
            $notify_stmt->execute();
            
            $_SESSION['success_msg'] = "Vehicle rates updated successfully! Users have been notified.";
        }
        
        header("Location: settings.php");
        exit();
    }
}

            $update_sql = "UPDATE admin_vehicle_rates SET 
                          base_price = ?, 
                          per_km = ?, 
                          per_passenger = ? 
                          WHERE vehicle_type = ?";
            $stmt = $conn->prepare($update_sql);

            if (!$stmt) {
                $error = "Database error: " . $conn->error;
                $success = false;
                break;
            }

            $stmt->bind_param("ddds", $base_price, $per_km, $per_passenger, $vehicle_type);

            if (!$stmt->execute()) {
                $error = "Failed to update rates for " . ucfirst($vehicle_type);
                $success = false;
                break;
            }
        }

        if ($success) {
            $_SESSION['success_msg'] = "Vehicle rates updated successfully!";
            header("Location: settings.php");
            exit();
        }
    }
}

// Show success message if set
if (isset($_SESSION['success_msg'])) {
    $success = $_SESSION['success_msg'];
    unset($_SESSION['success_msg']);
}

// Fetch current settings
$sql = "SELECT * FROM admin_vehicle_rates";
$result = $conn->query($sql);
$vehicle_rates = [];
while ($row = $result->fetch_assoc()) {
    $vehicle_rates[$row['vehicle_type']] = $row;
}
if (isset($_POST['save_design'])) {
    // Basic settings with defaults
    $primary_color = $_POST['primary_color'] ?? '#4a2800';
    $secondary_color = $_POST['secondary_color'] ?? '#ffffff';
    $font_family = $_POST['font_family'] ?? 'Arial';

    // Handle file uploads
    $upload_dir = '../uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

// Process logo upload
if (!empty($_FILES['logo']['name'])) {
    $logo_name = time() . '_' . basename($_FILES['logo']['name']);
    $logo_path = $upload_dir . $logo_name;
    $db_logo_path = 'uploads/' . $logo_name;

    if (move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path)) {
        // Delete old logo file if exists
        if (!empty($settings['logo_url'])) {
            $old_logo = '../' . $settings['logo_url'];
            if (file_exists($old_logo)) {
                unlink($old_logo);
            }
        }
        
        // Save logo URL to DB
        $sql_logo = "UPDATE site_settings SET setting_value = ? WHERE setting_name = 'logo_url'";
        if ($stmt_logo = $conn->prepare($sql_logo)) {
            $stmt_logo->bind_param("s", $db_logo_path);
            $stmt_logo->execute();
            $stmt_logo->close();
        }
    }
}

// Process banner img upload
if (!empty($_FILES['banner']['name'])) {
    $banner_name = time() . '_' . basename($_FILES['banner']['name']);
    $banner_path = $upload_dir . $banner_name;
    $db_banner_path = 'uploads/' . $banner_name;

    if (move_uploaded_file($_FILES['banner']['tmp_name'], $banner_path)) {
        // Delete old banner
        if (!empty($settings['banner_url'])) {
            $old_banner = '../' . $settings['banner_url'];
            if (file_exists($old_banner)) {
                unlink($old_banner);
            }
        }
        
        // Save banner URL
        $sql_banner = "UPDATE site_settings SET setting_value = ? WHERE setting_name = 'banner_url'";
        if ($stmt_banner = $conn->prepare($sql_banner)) {
            $stmt_banner->bind_param("s", $db_banner_path);
            $stmt_banner->execute();
            $stmt_banner->close();
        }
    }
}

// Save homepage and promo content
$homepage_text = $_POST['homepage_text'] ?? '';
$promo_text = $_POST['promo_text'] ?? '';
$promo_discount = $_POST['promo_discount'] ?? '';

$content_sql = "INSERT INTO site_settings (setting_name, setting_value) VALUES 
                ('homepage_text', ?),
                ('promo_text', ?),
                ('promo_discount', ?)
                ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";

if ($stmt_content = $conn->prepare($content_sql)) {
    $stmt_content->bind_param("sss", $homepage_text, $promo_text, $promo_discount);
    $stmt_content->execute();
    $stmt_content->close();
}

    // Save basic settings
    $sql = "INSERT INTO site_settings (setting_name, setting_value) VALUES 
            ('primary_color', ?),
            ('secondary_color', ?),
            ('font_family', ?)
            ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $primary_color, $secondary_color, $font_family);

    if ($stmt->execute()) {
        $_SESSION['success_msg'] = "Website design updated successfully!";
        header("Location: settings.php");
        exit();
    } else {
        $error = "Failed to update website design.";
    }
}

// Add this before the HTML to fetch design settings
$design_sql = "SELECT * FROM site_settings";
$design_result = $conn->query($design_sql);
$settings = [];
while ($row = $design_result->fetch_assoc()) {
    $settings[$row['setting_name']] = $row['setting_value'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Settings - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/dynamic_styles.php">    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .settings-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .vehicle-section {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Settings</h2>

            <!-- Tabs for different settings -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#rates">Vehicle Rates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#design">Website Design</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Vehicle Rates Tab -->
                <div class="tab-pane fade show active" id="rates">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <div class="settings-card">
                        <form method="POST">
                            <?php foreach(['car premium', 'auto', 'bike'] as $vehicle_type): ?>
                                <div class="vehicle-section">
                                    <h4 class="mb-3"><?php echo ucfirst($vehicle_type); ?> Rates</h4>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Base Price (₹)</label>
                                            <input type="number" 
                                                   name="rates[<?php echo $vehicle_type; ?>][base_price]" 
                                                   class="form-control" 
                                                   value="<?php echo $vehicle_rates[$vehicle_type]['base_price'] ?? '0'; ?>" 
                                                   step="0.01" 
                                                   min="0" 
                                                   required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Per KM Rate (₹)</label>
                                            <input type="number" 
                                                   name="rates[<?php echo $vehicle_type; ?>][per_km]" 
                                                   class="form-control" 
                                                   value="<?php echo $vehicle_rates[$vehicle_type]['per_km'] ?? '0'; ?>" 
                                                   step="0.01" 
                                                   min="0" 
                                                   required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Per Additional Passenger (₹)</label>
                                            <input type="number" 
                                                   name="rates[<?php echo $vehicle_type; ?>][per_passenger]" 
                                                   class="form-control" 
                                                   value="<?php echo $vehicle_rates[$vehicle_type]['per_passenger'] ?? '0'; ?>" 
                                                   step="0.01" 
                                                   min="0" 
                                                   required>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary">Save Vehicle Rates</button>
                        </form>
                    </div>
                </div>

                <!-- Website Design Tab -->
                <div class="tab-pane fade" id="design">
    <!-- Customize Website Design -->
    <div class="settings-card mb-5">
        <h4 class="mb-3">Customize Website Design</h4>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Primary Color</label>
                <input type="color" 
                       name="primary_color" 
                       class="form-control form-control-color" 
                       value="<?php echo $settings['primary_color'] ?? '#4a2800'; ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Secondary Color</label>
                <input type="color" 
                       name="secondary_color" 
                       class="form-control form-control-color" 
                       value="<?php echo $settings['secondary_color'] ?? '#ffffff'; ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*">
                <?php if (!empty($settings['logo_url'])): ?>
                <?php endif; ?>
            </div>


            <button type="submit" name="save_design" class="btn btn-primary">Save All Changes</button>
        </form>
    </div>
</div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
