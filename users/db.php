<?php
$host = "localhost"; // XAMPP ya WAMP use kar rahe ho toh "localhost" hi rahega
$username = "root";  // Default MySQL username
$password = "";      // Default password (agar blank hai toh "")
$dbname = "ridenowdbt"; // Tumhara database ka naam

// Database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
