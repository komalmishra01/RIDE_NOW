<?php
session_start();
include 'db.php'; // Ensure database connection is correctly set up

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST["fullname"]) ? trim(htmlspecialchars($_POST["fullname"])) : "";
    $dob = isset($_POST["dob"]) ? $_POST["dob"] : "";
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $user_type = isset($_POST["user_type"]) ? $_POST["user_type"] : "customer"; // Default customer

    // Check if any required field is empty
    if (empty($fullname) || empty($dob) || empty($phone) || empty($email) || empty($password) || empty($user_type)) {
        echo "Error: All fields are required!";
        exit();
    }

    // Validate phone number
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        echo "Error: Invalid phone number format! Enter a 10-digit number.";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Error: Invalid email format!";
        exit();
    }

    // Validate password (at least 6 chars, 1 uppercase, 1 number)
    if (strlen($password) < 6 || !preg_match("/[A-Z]/", $password) || !preg_match("/\d/", $password)) {
        echo "Error: Password must be at least 6 characters long, contain 1 uppercase letter, and 1 number.";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email or phone already exists
    $check_sql = "SELECT * FROM users WHERE email = ? OR phone = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $email, $phone);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: Email or phone number already registered!";
        exit();
    }
    $check_stmt->close();

    // Prepare the SQL statement
    $sql = "INSERT INTO users (fullname, dob, phone, email, password, user_type) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error in SQL Query: " . $conn->error;
        exit();
    }

    // Bind parameters to prevent SQL injection
    $stmt->bind_param("ssssss", $fullname, $dob, $phone, $email, $hashed_password, $user_type);

    // Execute query
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $fullname;
        $_SESSION['user_email'] = $email;

        echo "Registration successful! Redirecting to dashboard...";
        header("refresh:0; url=INDEX.php"); // Redirect after 2 seconds
        exit();
    } else {
        echo "Error: Could not complete registration. Please try again.";
    }

    // Close connections
    $stmt->close();
    $conn->close();
}
?>
