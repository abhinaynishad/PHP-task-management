 <!-- <?php
session_start();
$conn  = mysqli_connect("localhost","root","","user_system");
?>

<form method="POST">


    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
    <p>don,t have a account please <a href="register.php">register??</a></p>
    <?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password  = $_POST['password'];
    
    $sql = "SELECT * FROM loginpage WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['name'];   //store user
            header("Location: dashbord.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with this email!";
    }
}
?>
</form> -->   


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
            $_SESSION['user'] = $row['name']; // store user session
            header("Location: dashbord.php");
            exit();
        } else {
            $error = "❌ Invalid password!";
        }
    } else {
        $error = "❌ No user found with this email!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit" name="login">Login</button>
        <p>Don’t have an account? <a href="register.php">Register</a></p>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </form>
</body>
</html>

<style>
   input{
    height: 30px;
   }

 form{
          align-items: center;
            display: flex;
            justify-content: center;
            flex-direction: column;
            width: 300px;
            height: 350px;
            border: 1px solid black;
            padding: 0 5px ;
            border-radius: 20px;
        }
        button{
            background-color: aqua;
            width: 100px;

        }

        body{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;

        }
        input::placeholder{
            text-align: center;
        }
    </style>
<!-- <form method="POST">


    <h2>Login</h2>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit" name="login">Login</button>
    <p>don,t have a account please <a href="register.php">register??</a></p>
</form> -->

