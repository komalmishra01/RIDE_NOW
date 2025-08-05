<?php
// **Database Configuration**
if (!defined('DB_SERVER')) define('DB_SERVER', 'localhost');
if (!defined('DB_USERNAME')) define('DB_USERNAME', 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
if (!defined('DB_NAME')) define('DB_NAME', 'ridenowdbt');

// **Start Session (If not already started)**
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// **Database Connection**
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// **Check Connection & Error Handling**
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// **Set Character Encoding to UTF-8**
$conn->set_charset("utf8");

?>
