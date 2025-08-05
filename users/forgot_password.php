<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<style>
    body {
        background: #ffffff;
        font-family: Arial, sans-serif;
    }

    .forgot-container {
        max-width: 400px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .icon-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .key-icon {
        color: #0099ff;
        font-size: 24px;
        margin-right: 10px;
    }

    .icon-circle {
        width: 100px;
        height: 100px;
        background: #0099ff;
        border-radius: 50%;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-circle i {
        font-size: 40px;
        color: white;
    }

    h2 {
        color: #333;
        font-size: 24px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-input {
        width: 100%;
        padding: 12px 15px;  /* Removed left padding for icon */
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 15px;
    }
    .input-group {
        position: relative;
        margin-bottom: 20px;
    }

    .input-hint {
        font-size: 12px;
        color: #666;
        margin-top: 5px;
        margin-left: 5px;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #dc3545;
        font-size: 16px;
    }
    .submit-btn {
        width: 100%;
        padding: 12px;
        background: #0099ff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .submit-btn:hover {
        background: #0088ee;
    }

    .alert {
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 20px;
        background: #ffe6e6;
        border: 1px solid #ffcccc;
        color: #dc3545;
    }

    .sign-in-link {
        text-align: right;
        margin-top: 20px;
    }

    .sign-in-link a {
        color: #0099ff;
        text-decoration: none;
        font-size: 14px;
    }
</style>

<div class="forgot-container">
    <div class="icon-header">
        <div class="icon-circle">
            <i class="fas fa-user-lock"></i>
        </div>
    </div>
    
    <h2><i class="fas fa-key key-icon"></i>Set Password</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert">
            <?php 
            if ($_GET['error'] == 'email_not_found') {
                echo "Email address not found!";
            } elseif ($_GET['error'] == 'mail_error') {
                echo "Error sending email. Please try again.";
            } elseif ($_GET['error'] == 'db_error') {
                echo "Database error. Please try again.";
            }
            ?>
        </div>
    <?php endif; ?>
    
    <form action="send_otp.php" method="POST">
        <div class="input-group">
            <input type="email" name="email" class="form-input" placeholder="Enter your email" required>
            <div class="input-hint">(minimum 6 characters in length)</div>
        </div>
        <button type="submit" class="submit-btn">Reset Password</button>
    </form>
    <div class="sign-in-link">
        <a href="login.php">Sign In</a>
    </div>
</div>

<?php include 'footer.php'; ?>