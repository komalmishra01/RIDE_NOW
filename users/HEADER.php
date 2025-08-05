<?php
// Start session only if it hasn't already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';  // Add database connection

// Fetch logo from settings
$logo_sql = "SELECT setting_value FROM site_settings WHERE setting_name = 'logo_url'";
$logo_result = $conn->query($logo_sql);
$logo_url = $logo_result->fetch_assoc()['setting_value'] ?? 'img/LOGO.png';

$isLoggedIn = isset($_SESSION['user_id']); // Check if user is logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navbar with Profile Offcanvas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles/dynamic_styles.php">
    <style>
        body {
            margin-top: 70px;
            background-color: rgb(255, 255, 255);
            color: rgb(116, 95, 95);
        }
        .navbar-custom {
            background: #1c1c1c;
            padding: 10px 15px;
        }
        .navbar-brand img {
            height: 40px;
            cursor: pointer;
        }
        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
        }
        .profile-icon {
            font-size: 20px;
            color: white;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }
        .profile-icon:hover {
            transform: scale(1.2);
            color: #f8f9fa;
        }

        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            width: 350px;
        }
        .notification {
            background: linear-gradient(145deg, #ffffff, #f0f0f0);
            border-left: 4px solid #0dcaf0;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            padding: 15px;
            animation: slideIn 0.5s ease-out;
        }
        .notification-header {
            color: #1a1a1a;
            font-weight: 500;
            margin-bottom: 8px;
        }
        .notification-body {
            color: #4a4a4a;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .notification-time {
            color: #888;
            font-size: 0.8rem;
            margin-top: 8px;
        }
        .notification .btn-close {
            opacity: 0.5;
            transition: opacity 0.2s;
        }
        .notification .btn-close:hover {
            opacity: 1;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes fadeOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo htmlspecialchars($logo_url); ?>" alt="Logo" style="height: 30px; margin-right: 10px;"> RIDENOW
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="About.php"><i class="fas fa-info-circle"></i> About Us</a></li>
                    <li><a class="dropdown-item" href="gallery.php"><i class="fas fa-images"></i> Gallery</a></li>
                    <li><a class="dropdown-item" href="services.php"><i class="fas fa-concierge-bell"></i> Services</a></li>
                    <li><a class="dropdown-item" href="mybookings.php"><i class="fas fa-history"></i> My Bookings</a></li>
                </ul>
            </div>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="CONTACT.php"><i class="fas fa-envelope"></i> Contact Us</a></li>

                    <?php if (!$isLoggedIn): ?>
                        <li class="nav-item"><a class="nav-link" href="Login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="Register.php"><i class="fas fa-user-plus"></i> Sign Up</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="Profile.php"><i class="fas fa-user-circle"></i> My Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-user-circle"></i> Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Notifications container -->
    <div id="notifications" class="notification-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <script>
    function checkNotifications() {
        $.ajax({
            url: 'check_notifications.php',
            type: 'GET',
            success: function(response) {
                try {
                    let notifications = typeof response === 'object' ? response : JSON.parse(response);
                    
                    if (notifications && notifications.length > 0) {
                        let notificationHtml = '';
                        notifications.forEach(notification => {
                            let message = notification.message
                                .replace(/\\n/g, '<br>')
                                .replace(/\\u20b9/g, '₹');
                            
                            notificationHtml += `
                                <div class="notification" id="notification-${notification.id}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="notification-header">Price Update</div>
                                        <button type="button" class="btn-close" onclick="markNotificationRead(${notification.id})"></button>
                                    </div>
                                    <div class="notification-body">${message}</div>
                                    <div class="notification-time">${new Date(notification.created_at).toLocaleString()}</div>
                                </div>`;
                        });
                        $('#notifications').html(notificationHtml);
                    }
                } catch (e) {
                    console.error('Error parsing notifications:', e);
                    console.log('Raw response:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }

    function markNotificationRead(notificationId) {
        $(`#notification-${notificationId}`).css('animation', 'fadeOut 0.5s ease-out forwards');
        setTimeout(() => {
            $(`#notification-${notificationId}`).remove();
        }, 500);

        $.ajax({
            url: 'mark_notification_read.php',
            type: 'POST',
            data: { notification_id: notificationId }
        });
    }

    // Initial and repeated checks
    $(document).ready(function() {
        checkNotifications();
        setInterval(checkNotifications, 60000); // Every 1 minute
    });
    </script>
</body>
</html>
