<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles/dynamic_styles.php"></head>
<body>

<div class="sidebar">
    <h3>RIDE NOW Admin</h3>
     <ul class="nav flex-column">
        <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class='bx bxs-dashboard'></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="manage_bookings.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'bookings.php' ? 'active' : ''; ?>">
                <i class='bx bxs-calendar'></i> Bookings
            </a>
        </li>
        <li class="nav-item">
            <a href="users.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                <i class='bx bxs-user'></i> Users
            </a>
        </li>
        <li class="nav-item">
            <a href="drivers.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'drivers.php' ? 'active' : ''; ?>">
                <i class='bx bxs-car'></i> Drivers
            </a>
        </li>
        <li class="nav-item">
            <a href="manage_contacts.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage_contacts.php' ? 'active' : ''; ?>">
                <i class='bx bxs-envelope'></i> Contact Messages
            </a>
        </li>
        <li class="nav-item">
            <a href="manage_feedback.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage_feedback.php' ? 'active' : ''; ?>">
                <i class='bx bxs-message-dots'></i> Feedback
            </a>
        </li>
        <!-- Add News/Announcements Link -->


        <li class="nav-item">
            <a href="settings.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                <i class='bx bxs-cog'></i> Settings
            </a>
        </li>
        <a href="logout.php" class="nav-link text-danger mt-auto">
                <i class='bx bx-log-out'></i>
                <span>Logout</span>
            </a>
                </li>
    </ul>
</div>

<style>
.sidebar {
    width: 250px;
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    background: #2c3e50;
    padding: 20px;
    color: white;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.sidebar h3 {
    padding-bottom: 20px;
    margin-bottom: 20px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar .nav-link {
    color: #ecf0f1;
    padding: 12px 15px;
    display: flex;
    align-items: center;
    text-decoration: none;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.sidebar .nav-link i {
    margin-right: 10px;
    font-size: 1.2em;
}

.sidebar .nav-link:hover {
    background: rgba(255,255,255,0.1);
    color: #3498db;
}

.sidebar .nav-link.active {
    background: #3498db;
    color: white;
}

.main-content {
    margin-left: 250px;
    padding: 20px;
}

@media (max-width: 768px) {
    .sidebar {
        width: 70px;
        padding: 15px 10px;
    }
    
    .sidebar h3 {
        display: none;
    }
    
    .sidebar .nav-link span {
        display: none;
    }
    
    .main-content {
        margin-left: 70px;
    }
}
</style>