<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "user_system");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM loginpage WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// Update Logic
if (isset($_POST['update'])) {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    if (!empty($new_password)) {
        $hashed_pass = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE loginpage SET name='$new_name', email='$new_email', password='$hashed_pass' WHERE email='$email'";
    } else {
        $update_sql = "UPDATE loginpage SET name='$new_name', email='$new_email' WHERE email='$email'";
    }

    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['email'] = $new_email;
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Edit mode check
$edit_mode = isset($_GET['edit']) && $_GET['edit'] == '1';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
        <div class="card shadow p-4" style="width: 400px;">

        <h3>Your Profile</h3>

        <?php if (!$edit_mode): ?>
            <!-- View Only Mode -->
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

            <a href="profile.php?edit=1" class="btn btn-primary">Edit Profile</a>
            <a href="dashbord.php" class="btn btn-secondary">Back to Dashboard</a>

        <?php else: ?>
            <!-- Edit Mode Form -->
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password (leave blank if not changing)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <button type="submit" name="update" class="btn btn-success">Save Changes</button> <br><br>
                <a href="profile.php" class="btn btn-secondary">Cancel</a>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
