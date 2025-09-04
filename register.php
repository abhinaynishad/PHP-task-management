
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
$conn = mysqli_connect("localhost", "root", "", "user_system");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // password ko hash karna
    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

    // database me insert karna
    $sql = "INSERT INTO loginpage (name, email, password) VALUES ('$name', '$email', '$hashed_pass')";

    if (mysqli_query($conn, $sql)) {
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <div class="container bg-dark text-white">
    
    </div>


<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">
     <div class="card shadow p-4" style="width: 400px;">
    <h2 class="display-4 text-center ">Registration</h2>
    <form method="post">
  <div class="mb-3">
    <label for="name" class="form-label">name</label>
    <input type="text" name="name" class="form-control" id="name" >
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password"  class="form-control" id="exampleInputPassword1">
  </div>
  <button type="submit" name="register" class="btn btn-primary w-100">Submit</button><br>
   
    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
</form>
</div>
</div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>