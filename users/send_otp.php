<?php
session_start();
include 'config.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Prepare and check email in DB using 'user_id' from 'users' table
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        header("Location: forgot_password.php?error=db_error");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();    

    if ($result->num_rows > 0) {
        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['reset_email'] = $email;
        $_SESSION['otp_time'] = time();

        // Send OTP using PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            // ✅ Replace these with your actual credentials
            $mail->Username = 'ridhdhiraval2005@gmail.com'; // Your Gmail address
            $mail->Password = 'slfy dpfu ilrv qkcd'; // Your Gmail App Password

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('ridhdhiraval2005@gmail.com', 'RideNow');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP for password reset is: <b>$otp</b><br>This OTP will expire in 15 minutes.";

            $mail->send();
            header("Location: verify_otp.php");
            exit();
        } catch (Exception $e) {
            header("Location: forgot_password.php?error=mail_error");
            exit();
        }
    } else {
        header("Location: forgot_password.php?error=email_not_found");
        exit();
    }
}
?>
