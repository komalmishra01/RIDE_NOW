<?php 
include 'header.php'; 
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in!");
}

$user_id = $_SESSION['user_id']; 

// **Check if connection is working**
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// **Fetch User Data**
$sql = "SELECT fullname, email, phone, dob, profile_pic FROM users WHERE user_id=?";
$stmt = $conn->prepare($sql);

// ✅ Debugging: Check if statement is prepared correctly
if (!$stmt) {
    die("SQL Error: " . $conn->error); // 🔴 Print MySQL error
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $fullname = $row['fullname'];
    $email = $row['email'];
    $phone = $row['phone'];
    $dob = $row['dob'];
    $profile_pic = !empty($row['profile_pic']) ? "uploads/".$row['profile_pic'] : "img/default-profile.jpg";
} else {
    die("Error: User data not found!");
}

$stmt->close();
?>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 0;
    }

    .edit-profile-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .edit-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-pic-edit {
        text-align: center;
        margin-bottom: 20px;
    }

    .profile-pic-edit img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #6C63FF;
    }

    .pic-upload-btn {
        margin-top: 10px;
        background: #6C63FF;
        color: white;
        border: none;
        padding: 8px 15px;
        cursor: pointer;
        border-radius: 5px;
        transition: 0.3s;
    }

    .pic-upload-btn:hover {
        background: #5348cc;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: bold;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-input:focus {
        border-color: #6C63FF;
        outline: none;
    }

    .action-buttons {
        text-align: center;
        margin-top: 20px;
    }

    .save-btn, .cancel-btn {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    .save-btn {
        background: #6C63FF;
        color: white;
    }

    .save-btn:hover {
        background: #5348cc;
    }

    .cancel-btn {
        background: #ddd;
    }

    .cancel-btn:hover {
        background: #bbb;
    }
</style>

<div class="edit-profile-container">
    <div class="edit-header">
        <h1>Edit Profile</h1>
        <p>Update your personal information</p>
    </div>

    <form action="update-profile.php" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to save these changes?');">
        <div class="profile-pic-edit">
            <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" id="profilePreview">
            <br>
            <button type="button" class="pic-upload-btn" onclick="document.getElementById('profilePic').click()">
                <i class="fas fa-camera"></i> Change Photo
            </button>
            <input type="file" id="profilePic" name="profile_pic" hidden accept="image/*" onchange="previewImage(this)">
        </div>

        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-input" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" class="form-input" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
        </div>

        <div class="form-group">
            <label class="form-label">Phone Number</label>
            <input type="tel" class="form-input" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Date of Birth</label>
            <input type="date" class="form-input" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
        </div>

        <div class="action-buttons">
            <button type="submit" class="save-btn">
                <i class="fas fa-save"></i> Save Changes
            </button>
            <button type="button" class="cancel-btn" onclick="window.location.href='profile.php'">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php include 'footer.php'; ?> 
