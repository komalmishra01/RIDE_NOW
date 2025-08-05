<?php include 'header.php'; ?>
<?php include 'db.php'; ?> <!-- Database connection include -->

<style>
    .registration-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .form-section {
        flex: 1;
        max-width: 500px;
    }

    .illustration-section {
        flex: 1;
        text-align: right;
        padding-left: 50px;
    }

    .slideshow-container {
        position: relative;
        max-width: 400px;
        margin: auto;
    }

    .slides {
        display: none;
        width: 100%;
        border-radius: 10px;
    }

    .fade {
        animation: fadeEffect 3s;
    }

    @keyframes fadeEffect {
        from {opacity: 0.4;} 
        to {opacity: 1;}
    }

    h1 {
        font-size: 2rem;
        color: #0A0B26;
        margin-bottom: 20px;
        font-weight: bold;
        transition: transform 0.3s;
    }
    h1:hover {
        transform: scale(1.05);
        color: #6C63FF;
    }

    .form-input {
        width: 100%;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        margin-bottom: 5px;
    }
    .form-input:hover {
        border-color: #6C63FF;
        box-shadow: 0 0 5px rgba(108, 99, 255, 0.5);
    }

    .submit-btn {
        width: 100%;
        padding: 15px;
        background: #6C63FF;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }
    .submit-btn:hover {
        background: #5A52D5;
        transform: translateY(-2px) scale(1.05);
    }

    .error-msg {
        color: red;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        .registration-container {
            flex-direction: column;
        }
        .illustration-section {
            display: none;
        }
    }

    .input-group {
        position: relative;
        margin-bottom: 20px;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6C63FF;
        font-size: 16px;
        z-index: 1;
        pointer-events: none;
    }

    .form-input {
        width: 100%;
        padding: 15px 15px 15px 45px; /* Added left padding for icon */
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        margin-bottom: 5px;
    }

    .form-input:focus {
        border-color: #6C63FF;
        box-shadow: 0 0 5px rgba(108, 99, 255, 0.3);
    }

    .form-input:focus + .input-icon {
        color: #5A52D5;
    }
    .text-center {
    text-align: center;
}

.mt-3 {
    margin-top: 15px;
}

a:hover {
    text-decoration: underline !important;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="registration-container">
    <div class="form-section">
        <h1>Enter your details to begin.</h1>        
    
        <form id="registrationForm" action="registerprocess.php" method="post">
        <div class="input-group">
            <input type="text" class="form-input" name="fullname" placeholder="Full Name">
            <i class="input-icon fas fa-user"></i>
            <p class="error-msg" id="error-fullname"></p>
        </div>
        <div class="input-group">
            <input type="date" class="form-input" name="dob">
            <i class="input-icon fas fa-calendar"></i>
            <p class="error-msg" id="error-dob"></p>
        </div>
        <div class="input-group">
            <input type="tel" class="form-input" name="phone" placeholder="Phone Number">
            <i class="input-icon fas fa-phone"></i>
            <p class="error-msg" id="error-phone"></p>
        </div>
        <div class="input-group">
            <input type="email" class="form-input" name="email" placeholder="Email Address">
            <i class="input-icon fas fa-envelope"></i>
            <p class="error-msg" id="error-email"></p>
        </div>
        <div class="input-group">
            <input type="password" class="form-input" name="password" placeholder="Password">
            <i class="input-icon fas fa-lock"></i>
            <p class="error-msg" id="error-password"></p>
        </div>
        <button type="submit" class="submit-btn">Sign Up</button>
        <p class="text-center mt-3">
            Already have an account? <a href="login.php" style="color: #6C63FF; text-decoration: none; font-weight: 500;">Login</a>
        </p>
    </form>
    </div>
    
    <div class="illustration-section">
        <div class="slideshow-container">
            <img class="slides fade" src="img/z.jpg.png" alt="Slide 1">
            <img class="slides fade" src="img/y.jpg.png" alt="Slide 2">
            <img class="slides fade" src="img/x.jpg.png" alt="Slide 3">
        </div>
    </div>
</div>

<script>
    document.getElementById("registrationForm").addEventListener("submit", function(event) {
        event.preventDefault();
        let isValid = true;
        let phonePattern = /^[0-9]{10}$/;
        let passwordPattern = /^(?=.*[A-Z])(?=.*\d).{6,}$/;

        document.querySelectorAll(".error-msg").forEach(el => el.innerText = "");
        document.querySelectorAll(".form-input").forEach(input => {
            if (input.value.trim() === "") {
                document.getElementById(`error-${input.name}`).innerText = "This field is required.";
                isValid = false;
            }
        });

        if (!phonePattern.test(document.querySelector("input[name='phone']").value)) {
            document.getElementById("error-phone").innerText = "Enter a valid 10-digit phone number.";
            isValid = false;
        }

        if (!passwordPattern.test(document.querySelector("input[name='password']").value)) {
            document.getElementById("error-password").innerText = "Password must be at least 6 characters with 1 uppercase and 1 number.";
            isValid = false;
        }

        if (isValid) this.submit();
    });

    let slideIndex = 0;
    function showSlides() {
        let slides = document.getElementsByClassName("slides");
        for (let i = 0; i < slides.length; i++) slides[i].style.display = "none";
        slideIndex++;
        if (slideIndex > slides.length) slideIndex = 1;
        slides[slideIndex - 1].style.display = "block";
        setTimeout(showSlides, 3000);
    }
    showSlides();
</script>

<?php include 'footer.php'; ?>  
