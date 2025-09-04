
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "user_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Email se user fetch karo
    $sql = "SELECT * FROM loginpage WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Password verify karo
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['name']; 
            $_SESSION['email'] = $row['email']; 
            header("Location: dashbord.php");
            exit();
        } else {
            $error = " Invalid password!";
        }
    } else {
        $error = " No user found with this email!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body class="bg-light"> 
    <div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
        <div class="card shadow p-4" style="width: 400px;">
            <h2 class="text-center mb-4">Login</h2>
            
            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
            <p class="mt-3 text-center">Don’t have an account? <a href="register.php">Register</a></p>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
