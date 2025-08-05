<?php include 'header.php'; ?>

<style>
    body {
        background: url('img/bg7.jpg') no-repeat center center fixed;
        background-size: cover;
        position: relative;
        margin: 0;
        min-height: 100vh;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
        z-index: -1;
    }

    .login-container {
        max-width: 400px;
        margin: 100px auto;
        padding: 30px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .login-title {
        color: white;
        font-size: 2rem;
        margin-bottom: 10px;
        text-align: center;
    }

    .login-subtitle {
        color: #e0e0e0;
        text-align: center;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 5px;
        padding: 12px 15px;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.2);
        border-color: #007bff;
        box-shadow: none;
        outline: none;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .error-msg {
        color: red;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .login-btn {
        width: 100%;
        padding: 12px;
        background: #007bff;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        background: #0056b3;
        transform: translateY(-2px);
    }

    .text-center {
        text-align: center;
    }

    .mt-3 {
        margin-top: 15px;
    }

    .mt-4 {
        margin-top: 20px;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline !important;
    }

    .forgot-password {
        text-align: center;
        margin-top: 10px;
    }

    .error-alert {
        background-color: rgba(220, 53, 69, 0.1);
        color: #ff4444;
        padding: 12px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
        border: 1px solid rgba(220, 53, 69, 0.2);
        backdrop-filter: blur(5px);
    }
</style>

<div class="login-container">
    <h1 class="login-title">Welcome back!</h1>
    <p class="login-subtitle">Please enter your login details.</p>

    <?php
    if (isset($_GET['error'])) {
        echo '<div class="error-alert">';
        switch($_GET['error']) {
            case 'wrong_password':
                echo 'Incorrect password. Please try again.';
                break;
            case 'wrong_email':
                echo 'No account found with this email.';
                break;
        }
        echo '</div>';
    }
    ?>

    <form id="loginForm" action="loginprocess.php" method="post">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Enter email or phone number" name="email">
            <p class="error-msg" id="error-email"></p>
        </div>

        <div class="form-group">
            <input type="password" class="form-control" placeholder="Enter password" name="password">
            <p class="error-msg" id="error-password"></p>
        </div>

        <button type="submit" class="login-btn mt-4">Login</button>

        <p class="text-center mt-3" style="color: white;">
            Don't have an account? <a href="Register.php" style="color: #6C63FF; font-weight: 500;">Sign Up</a>
        </p>

        <div class="forgot-password">
            <a href="forgot_password.php" style="color: #6C63FF;">Forgot Password?</a>
        </div>
    </form>
</div>

<script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();
        let isValid = true;
        let emailInput = document.querySelector("input[name='email']");
        let passwordInput = document.querySelector("input[name='password']");

        document.querySelectorAll(".error-msg").forEach(el => el.innerText = "");
        
        if (emailInput.value.trim() === "") {
            document.getElementById("error-email").innerText = "Email or phone number is required.";
            isValid = false;
        }

        if (passwordInput.value.trim() === "") {
            document.getElementById("error-password").innerText = "Password is required.";
            isValid = false;
        }

        if (isValid) this.submit();
    });
</script>

<?php include 'footer.php'; ?>
