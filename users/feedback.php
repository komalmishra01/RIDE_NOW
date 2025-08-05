<?php
session_start();
include 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'] ?? null;
    
    $sql = "INSERT INTO feedback (user_id, rating, comment, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $user_id, $rating, $comment);
    
    if ($stmt->execute()) {
        // Get user details for the email
        $user_sql = "SELECT fullname, email FROM users WHERE user_id = ?";
        $user_stmt = $conn->prepare($user_sql);
        $user_stmt->bind_param("i", $user_id);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        $user = $user_result->fetch_assoc();

        // Create PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ridhdhiraval2005@gmail.com'; // Replace with your email
            $mail->Password = 'slfy dpfu ilrv qkcd';    // Replace with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('ridhdhiraval2005@gmail.com', 'Komal Mishra');
            $mail->addAddress('ridhdhiraval2005@gmail.com'); // Replace with admin email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Feedback Received - RIDE NOW';
            $mail->Body = "
                <h2>New Feedback Submission</h2>
                <p><strong>User Name:</strong> {$user['fullname']}</p>
                <p><strong>User Email:</strong> {$user['email']}</p>
                <p><strong>Rating:</strong> {$rating} stars</p>
                <p><strong>Comment:</strong> {$comment}</p>
            ";

            $mail->send();
            $success = "Thank you for your feedback!";
        } catch (Exception $e) {
            $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Failed to submit feedback.";
    }
}

// ... rest of the existing code remains the same ...
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback - RIDE NOW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">

<style>
    .feedback-form {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .rating {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        margin: 20px 0;
    }
    .emoji-container {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 10px;
    }
    .rating input[type="radio"] {
        display: none;
    }
    .emoji-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        cursor: pointer;
    }
    .emoji {
        width: 50px;
        height: 50px;
        background-size: contain;
        transition: transform 0.2s;
    }
    .emoji-text {
        font-size: 12px;
        font-weight: bold;
    }
    .progress-bar {
        width: 100%;
        height: 10px;
        background: linear-gradient(to right, #ff4444, #ff8844, #ffdd44, #88dd44, #44dd44);
        border-radius: 5px;
        margin-top: 10px;
    }
    .progress-indicator {
        width: 20px;
        height: 20px;
        background: #333;
        border-radius: 50%;
        margin-top: -15px;
        transition: margin-left 0.3s;
    }
</style>
</head>
<body class="bg-light">
<?php include 'HEADER.php'; ?>

<div class="container">
    <div class="feedback-form">
        <h2 class="text-center mb-4" style="color: #4a2800; font-family: 'Arial Black', sans-serif;">YOUR FEEDBACK</h2>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="rating">
                <div class="emoji-container">
                    <div class="emoji-label">
                        <input type="radio" name="rating" value="1" id="rate1">
                        <label for="rate1">
                            <img src="img/emoji-1.png" alt="Angry" class="emoji">
                        </label>
                        <span class="emoji-text">TERRIBLE</span>
                    </div>
                    <div class="emoji-label">
                        <input type="radio" name="rating" value="2" id="rate2">
                        <label for="rate2">
                            <img src="img/emoji-2.png" alt="Sad" class="emoji">
                        </label>
                        <span class="emoji-text">BAD</span>
                    </div>
                    <div class="emoji-label">
                        <input type="radio" name="rating" value="3" id="rate3">
                        <label for="rate3">
                            <img src="img/emoji-3.png" alt="Neutral" class="emoji">
                        </label>
                        <span class="emoji-text">OKAY</span>
                    </div>
                    <div class="emoji-label">
                        <input type="radio" name="rating" value="4" id="rate4">
                        <label for="rate4">
                            <img src="img/emoji-4.png" alt="Happy" class="emoji">
                        </label>
                        <span class="emoji-text">GOOD</span>
                    </div>
                    <div class="emoji-label">
                        <input type="radio" name="rating" value="5" id="rate5">
                        <label for="rate5">
                            <img src="img/emoji-5.png" alt="Excellent" class="emoji">
                        </label>
                        <span class="emoji-text">EXCELLENT</span>
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-indicator"></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Your suggestions</label>
                <textarea class="form-control" name="comment" rows="4" placeholder="Share your feedback with us..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
        </form>
    </div>
</div>

<?php include 'FOOTER.php'; ?>

<script>
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    const progressIndicator = document.querySelector('.progress-indicator');
    const emojis = document.querySelectorAll('.emoji');

    ratingInputs.forEach((input, index) => {
        input.addEventListener('change', () => {
            // Update progress indicator position
            const position = (index * 25) + '%';
            progressIndicator.style.marginLeft = position;

            // Reset all emojis
            emojis.forEach(emoji => {
                emoji.style.transform = 'scale(1)';
            });

            // Scale up selected emoji
            emojis[index].style.transform = 'scale(1.2)';
        });
    });
</script>
</body>
</html>