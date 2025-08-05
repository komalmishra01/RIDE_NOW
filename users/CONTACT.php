<?php include 'header.php'; ?>

<style>
    body {
        background: url('img/bg7.jpg') no-repeat center center fixed;
        background-size: cover;
        font-family: Arial, sans-serif;
        position: relative;
        color: white;
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
        -webkit-backdrop-filter: blur(3px);
        z-index: -1;
    }

    .contact-container {
        position: relative;
        background: rgba(255, 255, 255, 0.1);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
        max-width: 700px;
        margin: 80px auto;
        animation: fadeIn 1s ease-in-out;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(2px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        z-index: 1;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-label {
        color: white;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.5);
        color: white;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.3);
        outline: none;
        color: white;
    }

    .btn-custom {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        border: none;
        padding: 12px;
        width: 100%;
        border-radius: 10px;
        font-size: 16px;
        color: white;
        transition: 0.3s ease;
    }

    .btn-custom:hover {
        background: linear-gradient(to right, #5a0fb2, #1e60d4);
    }

    .error {
        color: #ffdddd;
        font-size: 14px;
        margin-top: 5px;
    }

    .alert {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .alert-success {
        background-color: rgba(76, 175, 80, 0.2);
        color: #4CAF50;
        border: 1px solid #4CAF50;
    }

    .alert-danger {
        background-color: rgba(244, 67, 54, 0.2);
        color: #f44336;
        border: 1px solid #f44336;
    }
</style>

<div class="container">
    <div class="contact-container">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success text-center">
                Message sent successfully! We'll get back to you soon.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center">
                <?php 
                if ($_GET['error'] === 'empty') {
                    echo "Please fill all fields.";
                } else {
                    echo "Something went wrong. Please try again.";
                }
                ?>
            </div>
        <?php endif; ?>

        <h1 class="text-center">Get in Touch</h1>
        <p class="text-center">We'd love to hear from you! Drop us a message below.</p>
        <form id="contactForm" action="sendmessage.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                <span class="error" id="nameError"></span>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                <span class="error" id="emailError"></span>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Write your message"></textarea>
                <span class="error" id="messageError"></span>
            </div>
            <button type="submit" class="btn btn-custom">Send Message</button>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<script>
    $(document).ready(function () {
        $("#contactForm").validate({
            rules: {
                name: { required: true, minlength: 3 },
                email: { required: true, email: true },
                message: { required: true, minlength: 10 }
            },
            messages: {
                name: { required: "Please enter your name", minlength: "Name should be at least 3 characters" },
                email: { required: "Please enter your email", email: "Enter a valid email address" },
                message: { required: "Please enter your message", minlength: "Message should be at least 10 characters" }
            },
            errorPlacement: function (error, element) {
                var id = element.attr("id") + "Error";
                $("#" + id).html(error);
            },
            success: function (label, element) {
                var id = $(element).attr("id") + "Error";
                $("#" + id).html("");
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>

<?php include 'footer.php'; ?>
