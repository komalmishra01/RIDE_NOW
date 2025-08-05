<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from database
$sql = "SELECT fullname, dob, phone, email, profile_pic FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);  // Error handling for prepare()
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullname = htmlspecialchars($row['fullname']); // ✔️ Sahi hai (database me 'fullname' hai)
    $dob = htmlspecialchars($row['dob']);
    $phone = htmlspecialchars($row['phone']);
    $email = htmlspecialchars($row['email']);
    $profile_pic = !empty($row['profile_pic']) ? htmlspecialchars($row['profile_pic']) : 'img/default-profile.jpg';
} else {
    die("Error: User not found!");
}
$stmt->close();
?>

<style>
    body {
        background: url('img/bg7.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        min-height: 100vh;
        position: relative;
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
        z-index: -1;
    }
    .profile-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 30px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        text-align: center;
    }
    .profile-pic-container {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto 30px;
    }
    .profile-pic {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
    }
    .edit-pic-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #6C63FF;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .edit-pic-btn:hover {
        transform: scale(1.1);
    }
    .info-group {
        margin: 20px 0;
        text-align: left;
    }
    .info-label {
        font-size: 0.9em;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 5px;
    }
    .info-input {
        width: 100%;
        padding: 12px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: white;
        font-size: 1rem;
    }
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        justify-content: center;
    }
    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .btn-edit {
        background: #6C63FF;
        color: white;
    }
    .btn-back {
        background: #4CAF50;
        color: white;
    }
    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .btn-logout {
        background: #ff4444;
        color: white;
    }
</style>

<div class="profile-container">

<div class="profile-container">
    <div class="profile-pic-container">
        <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="profile-pic" id="profilePic">
    </div>

    <div class="info-group">
        <div class="info-label">Full Name</div>
        <input type="text" class="info-input" value="<?php echo $fullname; ?>" readonly>
    </div>
    <div class="info-group">
        <div class="info-label">Date of Birth</div>
        <input type="date" class="info-input" value="<?php echo $dob; ?>" readonly>
    </div>
    <div class="info-group">
        <div class="info-label">Phone Number</div>
        <input type="tel" class="info-input" value="<?php echo $phone; ?>" readonly>
    </div>
    <div class="info-group">
        <div class="info-label">Email Address</div>
        <input type="email" class="info-input" value="<?php echo $email; ?>" readonly>
    </div>

    <div class="action-buttons">
        <button class="btn btn-edit" onclick="window.location.href='edit_profile.php'">
            <i class="fas fa-edit"></i> Edit Profile
        </button>
        <button class="btn btn-back" onclick="window.location.href='index.php'">
            <i class="fas fa-arrow-left"></i> Back
        </button>
        <button class="btn btn-logout" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>
</div>

<script>
    function updateProfilePic(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePic').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function logout() {
        if (confirm('Are you sure you want to logout?')) {
            window.location.href = 'logout.php';
        }
    }
</script>

