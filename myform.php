 <?php 
 session_start();
 $_SESSION['EMAIL']="ABC";
$conn = mysqli_connect('localhost', 'root', '', 'demo');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['mail'];
    $pass = $_POST['pass'];
    $gender = $_POST['gender'] ?? '';
    $subjects = $_POST['subject'] ?? [];
    $subject_str = implode(", ", $subjects);

    $image = $_FILES['img']['name'];
    $temp_name = $_FILES['img']['tmp_name'];
    $folder = "images/" . $image;
    move_uploaded_file($temp_name, $folder);

    $sql = "SELECT * FROM my_data WHERE email='$email'";
    $s = $conn->query($sql);

    if ($s->num_rows > 0) {
        echo "<script>alert('This email is already registered!'); window.history.back();</script>";
        exit();
    }

    $query = "INSERT INTO my_data (name,email,password,gender,image,subjects) 
              VALUES ('$name','$email','$pass','$gender','$image', '$subject_str')";

    if (empty($name) || empty($email) || empty($pass) || empty($gender) || empty($image) || empty($subject_str)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }

    $conn->query($query);
    header("Location: myform.php");
    exit();
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['mail'];
    $pass = $_POST['pass'];
    $gender = $_POST['gender'];
    $subjects = $_POST['subject'] ?? [];
    $subject_str = implode(", ", $subjects);

    if (!empty($_FILES['img']['name'])) {
        $image = $_FILES['img']['name'];
        $temp_name = $_FILES['img']['tmp_name'];
        $folder = "images/" . $image;
        move_uploaded_file($temp_name, $folder);

        // update with new photo
        $query = "UPDATE my_data 
                  SET name='$name', email='$email', password='$pass', gender='$gender', image='$image', subjects='$subject_str' 
                  WHERE id=$id";
    } else {
        // update without new photo
        $query = "UPDATE my_data 
                  SET name='$name', email='$email', password='$pass', gender='$gender', subjects='$subject_str' 
                  WHERE id=$id";
    }

    $conn->query($query);
    header("Location: myform.php");
    exit();
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM my_data WHERE id=$id";
    $conn->query($query);
    header("Location: myform.php");
    exit();
}

$editData = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM my_data WHERE id=$id");
    $editData = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Form</title>
    <style>
        #table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>My Form</h1>

    <?php 
    $selectedSubjects = [];
    if (!empty($editData['subjects'])) {
        $selectedSubjects = explode(", ", $editData['subjects']);
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

        NAME: <input type="text" name="name" value="<?php echo $editData['name'] ?? ''; ?>"><br>
        EMAIL: <input type="email" name="mail" value="<?php echo $editData['email'] ?? ''; ?>"><br>

        <label>
            <input type="radio" name="gender" value="male" 
                <?php if (($editData['gender'] ?? '') == 'male') echo 'checked'; ?>> Male
        </label><br>
        <label>
            <input type="radio" name="gender" value="female" 
                <?php if (($editData['gender'] ?? '') == 'female') echo 'checked'; ?>> Female
        </label><br>

        PASSWORD: <input type="password" name="pass" value="<?php echo $editData['password'] ?? ''; ?>"><br><br>

        chosen subjects:<br>
        <label>
            <input type="checkbox" name="subject[]" value="Physics" 
                <?php if (in_array("Physics", $selectedSubjects)) echo "checked"; ?>> Physics
        </label><br>
        <label>
            <input type="checkbox" name="subject[]" value="Chemistry" 
                <?php if (in_array("Chemistry", $selectedSubjects)) echo "checked"; ?>> Chemistry
        </label><br>
        <label>
            <input type="checkbox" name="subject[]" value="Math" 
                <?php if (in_array("Math", $selectedSubjects)) echo "checked"; ?>> Math
        </label><br><br>

        IMAGE: <input type="file" name="img"><br><br>

        <?php if (!empty($editData['image'])) { ?>
            Chosen Image : 
            <img style="height:50px" src="images/<?php echo $editData['image']; ?>" alt="No image Selected"><br><br>
        <?php } ?>

        <?php if (isset($_GET['id'])) { ?>
            <input type="submit" name="update" value="Update">
        <?php } else { ?>
            <input type="submit" name="submit" value="Add New">
        <?php } ?>
    </form>

    <h2>Data in Table</h2>
    <table id="table">
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Gender</th>
            <th>Subjects</th>
            <th>Image</th>
            <th>Action</th>
        </tr>

        <?php 
        $sql = "SELECT * FROM my_data";
        $res = $conn->query($sql);
        while ($row = $res->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['password'] ?></td>
                <td><?php echo $row['gender'] ?></td>
                <td><?php echo $row['subjects'] ?></td>
                <td><img src="images/<?php echo $row['image'] ?>" width="80px" height="80px"></td>
                <td><a href="myform.php?id=<?php echo $row['id']; ?>">Edit</a></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete" onclick="return confirm('Are you sure ?');"> Delete </button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>


    
</body>
</html> 
      

