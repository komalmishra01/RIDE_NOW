<?php
session_start();
include 'config.php';
?>

<style>
    body {
        background: url('img/bg1.jpg') no-repeat center center fixed;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.5));
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: -1;
    }

    .otp-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        border: 1px solid rgba(255, 255, 255, 0.18);
        transform: translateY(-20px);
        animation: float 6s ease-in-out infinite;
        position: relative;
        z-index: 1;
    }

    @keyframes float {
        0% { transform: translateY(-20px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(-20px); }
    }

    .form-input {
        width: 100%;
        padding: 15px 20px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 16px;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        background: rgba(255, 255, 255, 0.3);
        outline: none;
        box-shadow: 0 0 15px rgba(108, 99, 255, 0.5);
    }

    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .submit-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(45deg, #6C63FF, #3F3D9D);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .submit-btn:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            120deg,
            transparent,
            rgba(255, 255, 255, 0.2),
            transparent
        );
        transition: 0.5s;
    }

    .submit-btn:hover:before {
        left: 100%;
    }

    .submit-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(108, 99, 255, 0.4);
    }

    h2 {
        color: white;
        text-align: center;
        font-size: 28px;
        margin-bottom: 30px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .input-group {
        position: relative;
        margin-bottom: 25px;
    }

    .input-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.7);
    }
</style>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ... rest of your existing PHP code ...
?>
    <div class="otp-container">
        <h2>Reset Password</h2>
        <form action="update_password.php" method="POST">
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="new_password" class="form-input" placeholder="New Password" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock-alt"></i>
                <input type="password" name="confirm_password" class="form-input" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="submit-btn">Reset Password</button>
        </form>
    </div>
<?php
    // ... rest of your existing PHP code ...
}
?>