<?php 
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die("<br><strong>❌ Error:</strong> User not logged in!");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $dob = trim($_POST['dob']);
    
    // Handle profile picture upload
    $profile_pic = '';
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_pic']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if(in_array(strtolower($filetype), $allowed)) {
            $target_dir = "uploads/profile_pics/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $new_filename = "profile_" . $user_id . "_" . time() . "." . $filetype;
            $target_file = $target_dir . $new_filename;
            
            if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
                $profile_pic = $target_file;
            }
        }
    }

    // Check if user exists
    $checkUser = "SELECT fullname, phone, dob FROM users WHERE user_id = ?";
    $stmtCheck = $conn->prepare($checkUser);
    $stmtCheck->bind_param("i", $user_id);
    $stmtCheck->execute();
    $result = $stmtCheck->get_result();

    if ($result->num_rows == 0) {
        $insertUser = "INSERT INTO users (user_id, fullname, email, phone, dob, password, user_type, profile_pic) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertUser);
        $defaultPass = password_hash("testpassword", PASSWORD_DEFAULT);
        $defaultEmail = "test@example.com";
        $userType = "customer";

        $stmtInsert->bind_param("isssssss", $user_id, $fullname, $defaultEmail, $phone, $dob, $defaultPass, $userType, $profile_pic);
        $stmtInsert->execute();
        $stmtInsert->close();
    }

    // Update Query
    if($profile_pic != '') {
        $sql = "UPDATE users SET fullname=?, phone=?, dob=?, profile_pic=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $fullname, $phone, $dob, $profile_pic, $user_id);
    } else {
        $sql = "UPDATE users SET fullname=?, phone=?, dob=? WHERE user_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $fullname, $phone, $dob, $user_id);
    }

    if (!$stmt) {
        die("<br><strong>❌ SQL Error:</strong> " . $conn->error);
    }

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>alert('✅ Profile Updated Successfully!'); window.location.href='profile.php';</script>";
        } else {
            echo "<br><strong>⚠️ No changes made.</strong>";
        }
    } else {
        echo "<br><strong>❌ Query execution failed:</strong> " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>