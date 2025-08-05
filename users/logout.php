<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Delete session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out - RideNow</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #6C63FF, #4834d4);
            font-family: 'Arial', sans-serif;
        }

        .logout-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
            transform: scale(1);
            transition: transform 0.3s ease;
        }

        .logout-container:hover {
            transform: scale(1.02);
        }

        .logout-icon {
            font-size: 60px;
            color: #6C63FF;
            margin-bottom: 20px;
            animation: fadeIn 1s ease;
        }

        .logout-message {
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
            margin: 10px;
        }

        .btn-login {
            background: #6C63FF;
            color: white;
            border: 2px solid #6C63FF;
        }

        .btn-login:hover {
            background: #5348cc;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
        }

        .btn-home {
            background: transparent;
            color: #6C63FF;
            border: 2px solid #6C63FF;
        }

        .btn-home:hover {
            background: #6C63FF;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .redirect-message {
            color: #666;
            margin-top: 20px;
            font-size: 14px;
        }

        #countdown {
            font-weight: bold;
            color: #6C63FF;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <i class="fas fa-sign-out-alt logout-icon"></i>
        <div class="logout-message">You have been logged out successfully!</div>
        <div>
            <a href="login.php" class="btn btn-login">Login Again</a>
            <a href="index.php" class="btn btn-home">Home Page</a>
        </div>
        <div class="redirect-message">
            Redirecting to home page in <span id="countdown">5</span> seconds...
        </div>
    </div>

    <script>
        // Countdown and redirect
        let seconds = 5;
        const countdownDisplay = document.getElementById('countdown');
        
        const countdown = setInterval(() => {
            seconds--;
            countdownDisplay.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = 'index.php';
            }
        }, 1000);
    </script>
</body>
</html>