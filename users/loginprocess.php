<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if (empty($email) || empty($password)) {
        header("Location: login.php?error=empty_fields");
        exit();
    }

    // Check if user exists
    $sql = "SELECT user_id, fullname, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        header("Location: login.php?error=database_error");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Login successful
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['fullname'];
            $_SESSION['user_email'] = $row['email'];
            header("Location: INDEX.php");
            exit();
        } else {
            // Wrong password
            header("Location: login.php?error=wrong_password");
            exit();
        }
    } else {
        // Email not found
        header("Location: login.php?error=wrong_email");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>