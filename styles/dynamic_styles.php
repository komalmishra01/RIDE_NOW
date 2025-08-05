<?php
header('Content-type: text/css');
include 'd:/xampp/htdocs/RIDE_NOW/config.php';

// Fetch colors from settings
$sql = "SELECT * FROM site_settings WHERE setting_name IN ('primary_color', 'secondary_color')";
$result = $conn->query($sql);
$colors = [];
while ($row = $result->fetch_assoc()) {
    $colors[$row['setting_name']] = $row['setting_value'];
}

$primary_color = $colors['primary_color'] ?? '#1c1c1c';
$secondary_color = $colors['secondary_color'] ?? '#ffffff';
?>

:root {
    --primary-color: <?php echo $primary_color; ?>;
    --secondary-color: <?php echo $secondary_color; ?>;
}

body {
    background-color: var(--secondary-color) !important;
}

.navbar-custom {
    background: var(--primary-color) !important;
}

.navbar, .btn-primary, .sidebar {
    background-color: var(--primary-color) !important;
    color: var(--secondary-color) !important;
}

.bg-primary {
    background-color: var(--primary-color) !important;
}

.text-primary {
    color: var(--primary-color) !important;
}

.bg-secondary {
    background-color: var(--secondary-color) !important;
}

.card, .modal-content {
    background-color: var(--secondary-color);
}

.nav-link {
    color: var(--primary-color);
}

.nav-link.active {
    background-color: var(--primary-color) !important;
    color: var(--secondary-color) !important;
}
// Additional theme colors
.btn-hover:hover {
    background-color: var(--primary-color) !important;
    opacity: 0.9;
}

.promo-banner {
    background-color: var(--primary-color);
    color: var(--secondary-color);
    padding: 10px;
    text-align: center;
}

.logo-container img {
    max-height: 60px;
    width: auto;
}

.banner-container img {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
}