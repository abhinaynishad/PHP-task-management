<?php
session_start();
$v = $_SESSION['EMAIL'];
echo $v;
$conn = mysqli_connect('localhost','root','','demo');
if(!$conn){
    die("connection failed:".mysqli_connect_error());
}

$editdata = null;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM my_data WHERE id = $id");
    $editdata = $result->fetch_assoc();
}

$selectedSubjects = [];
if(!empty($editdata['subjects'])){
    $selectedSubjects =  explode(",",$editdata['subjects']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #table, th ,td{

            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
   <h1>my form</h1>
    
   <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $editdata['id']??'';?>">
    <input type="text" name="name" value="<?php echo $editdata['name']??'';?>"><br>
     <input type="email" name="mail" value="<?php echo $editdata['mail']??'';?>"><br>
      
     <input type="radio" name="gender" value="male" <?php if (($editdata['gender']??'')=='male')echo'checked';?>>male

     <input type="radio" name="gender" value="female" <?php if (($editdata['gender']??'')=='female')echo'checked';?>>female <br>
      <input type="password" name="pass" value="<?php echo $editdata['pass']??'';?>"><br>

      <input type="checkbox" name="subject[]" value="physics"<?php if (in_array("physics",$selectedSubjects))echo'checked';?>>physics
       <input type="checkbox" name="subject[]" value="chemistry"<?php if (in_array("chemistry",$selectedSubjects))echo'checked';?>>chemistry
       <input type="checkbox" name="subject[]" value="math"<?php if (in_array("math",$selectedSubjects))echo'checked';?>>math

       <input type="file" name="img"><br>
       <?php if (!empty($editdata['image'])){?>
    <img src="images/<?php echo $editdata['iamge'];?>" alt="no image selected">
     <?php  }?>
     <?php if (isset($_GET['id'])){?>
        <input type="submit" name="update" value="update" >

     <?php }else{?>
        <input type="submit" name="submit" value="add new">
        
     <?php }?>
   </form>

   <h2>data in table</h2>
   <table id="table">
    <tr>
      <th>id</th>
      <th>name</th>
      <th>email</th>
      <th>password</th>
      <th>gender</th>
      <th>subject</th>
      <th>image</th>
      <th>action</th>


     </tr>

     
     <?php
$sql = "SELECT * FROM my_data";
$res = $conn->query($sql);
while($row =$res->fetch_assoc()){?>

<tr>
    <td><?php echo $row['id'] ?></td>
    <td><?php echo $row['name'] ?></td>
    <td><?php echo $row['email'] ?></td>
    <td><?php echo $row['password'] ?></td>
    <td><?php echo $row['gender'] ?></td>
    <td><?php echo $row['subjects'] ?></td>
    <td><img src="images/<?php echo $row['image']?>" width="80px" height="80px"></td>
    <td><a href="myform.php?id=<?php echo $row['id'];?>">edit</a></td>
    <td>
        <form method="post">
            
            <input type="hidden" name="id" value="<?php echo $row['id'];?>">
            <button type="submit" name="delete" onclick="return confirm('are you sure delete')"></button>
        </form>
        
    </td>
    
</tr>

<?php }?>
</table>
</body>
</html>  

<?php 
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

    $sql = "SELECT * FROM my_data WHERE email = '$email'";
    $s = $conn->query($sql);
      
    if (empty($name)||empty($email)||empty($pas)||empty($gender)||empty($image)||empty($subject_str)){
      echo "<script>alert('all field are requred');window.history.back();</script>";
      exit();

    }
    $query = " INSERT INTO my_data (name,email,password,gender,image,subjects) VALUES ('$name','$email','$pass','$gender','$subject_str')";
    $conn->query($query);
    header("location: myform.php");
    exit();
}
