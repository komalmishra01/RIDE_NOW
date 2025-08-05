<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: CONTACT.php?error=empty");
        exit();
    }

    // Insert into database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        header("Location: CONTACT.php?success=1");
    } else {
        header("Location: CONTACT.php?error=db");
    }
    exit();
}

header("Location: CONTACT.php");
exit();
?>