<?php
include 'db.php'; // Database connection include karo

$sql = "SELECT * FROM users"; // users table se data fetch karo
$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row; // Data ko array me store karo
    }
}

// JSON format me data return karo (agar API ke liye chahiye)
echo json_encode($users);

$conn->close();
?>
