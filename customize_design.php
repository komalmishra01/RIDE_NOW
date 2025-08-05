<?php
session_start();
include '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Save settings
    $primary_color = $_POST['primary_color'];
    $secondary_color = $_POST['secondary_color'];
    $font_family = $_POST['font_family'];
    
    $sql = "INSERT INTO site_settings (setting_name, setting_value) VALUES 
            ('primary_color', ?), 
            ('secondary_color', ?),
            ('font_family', ?)
            ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $primary_color, $secondary_color, $font_family);
    
    if ($stmt->execute()) {
        $success = "Settings saved successfully!";
    } else {
        $error = "Failed to save settings.";
    }
}

// Get current settings
$sql = "SELECT * FROM site_settings";
$result = $conn->query($sql);
$settings = [];
while ($row = $result->fetch_assoc()) {
    $settings[$row['setting_name']] = $row['setting_value'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customize Website Design - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Customize Website Design</h2>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label>Primary Color</label>
                <input type="color" name="primary_color" class="form-control" 
                       value="<?php echo $settings['primary_color'] ?? '#4a2800'; ?>">
            </div>
            
            <div class="mb-3">
                <label>Secondary Color</label>
                <input type="color" name="secondary_color" class="form-control" 
                       value="<?php echo $settings['secondary_color'] ?? '#ffffff'; ?>">
            </div>
            
            <div class="mb-3">
                <label>Font Family</label>
                <select name="font_family" class="form-control">
                    <option value="Arial" <?php echo ($settings['font_family'] ?? '') == 'Arial' ? 'selected' : ''; ?>>Arial</option>
                    <option value="Helvetica" <?php echo ($settings['font_family'] ?? '') == 'Helvetica' ? 'selected' : ''; ?>>Helvetica</option>
                    <option value="Times New Roman" <?php echo ($settings['font_family'] ?? '') == 'Times New Roman' ? 'selected' : ''; ?>>Times New Roman</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>