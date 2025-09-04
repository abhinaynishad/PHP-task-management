<!-- <!-- <?php session_start();
$conn = mysqli_connect("localhost","root","","user_system");
?> -->

 <?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<h1>wel</h1>
 <?php echo $_SESSION['user']; ?>
<a href="logoutt.php">Logout</a> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dashboard</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap');

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: #f6f8fa;
    font-family: 'Poppins', sans-serif;
}

.container{
    max-width: 700px;
    width: 100%;
    background: #ffffff;
    border-radius: 0.5rem;
    box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.1),
                0px 5px 12px -2px rgba(0, 0, 0, 0.1),
                0px 18px 36px -6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 10px;
}

.container .title{
    padding: 25px;
    background: #f6f8fa;
}

.container .title p{
    font-size: 25px;
    font-weight: 500;
    position: relative;
}

.container .title p::before{
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 30px;
    height: 3px;
    background: linear-gradient(to right, #F37A65, #D64141);
}

.user_details{
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    padding: 25px;
}

.user_details .input_box{
    width: calc(100% / 2 - 20px);
    margin: 0 0 12px 0;
}

.input_box label{
    font-weight: 500;
    margin-bottom: 5px;
    display: block;
}

.input_box label::after{
    content: " *";
    color: red;
}

.input_box input{
    width: 100%;
    height: 45px;
    border: none;
    outline: none;
    border-radius: 5px;
    font-size: 16px;
    padding-left: 15px;
    box-shadow: 0px 0px 0px 1px rgba(0, 0, 0, 0.1);
    background-color: #f6f8fa;
    font-family: 'Poppins', sans-serif;
    transition: all 120ms ease-out 0s;
}


.input_box input:focus,
.input_box input:valid{
    box-shadow: 0px 0px 0px 2px #AC8ECE;
}

form .gender{
    padding: 0px 25px;
}

.gender .gender_title{
    font-size: 20px;
    font-weight: 500;
}

.gender .category{
    width: 80%;
    display: flex;
    justify-content: space-between;
    margin: 5px 0;
}

.gender .category label{
    display: flex;
    align-items: center;
    cursor: pointer;
}

.gender .category label .dot{
    height: 18px;
    width: 18px;
    background: #d9d9d9;
    border-radius: 50%;
    margin-right: 10px;
    border: 4px solid transparent;
    transition: all 0.3s ease;
}

#radio_1:checked ~ .category label .one,
#radio_2:checked ~ .category label .two,
#radio_3:checked ~ .category label .three{
    border-color: #d9d9d9;
    background: #D64141;
}

.gender input{
    display: none;
}

.reg_btn{
    padding: 25px;
    margin: 15px 0;
}

.reg_btn input{
    height: 45px;
    width: 100%;
    border: none;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
    background: linear-gradient(to right, #F37A65, #D64141);
    border-radius: 5px;
    color: #ffffff;
    letter-spacing: 1px;
    text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.2);
}

.reg_btn input:hover{
    background: linear-gradient(to right, #D64141, #F37A65);
}

@media screen and (max-width: 584px){

    .user_details{
        max-height: 340px;
        overflow-y: scroll;
    }

    .user_details::-webkit-scrollbar{
        width: 0;
    }

    .user_details .input_box{
        width: 100%;
    }

    .gender .category{
        width: 100%;
    }

}


@media screen and (max-width: 419px){
    .gender .category{
        flex-direction: column;
    }   
}
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            <p>DASHBOARD</p>
        </div>

        <form action="#">
            <div class="user_details">
                <div class="input_box">
                    <p>Welcome [NAME]</p>
                </div>

            </div>

            <div class="reg_btn">
                <p>Logout</p>
            </div>
        </form>
    </div>

   
</body>
</html> -->

<?php
session_start();

// Agar user login nahi hai to login page par redirect kar do
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Agar logout button click hua
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?> 👋</h2>
    <p>You are successfully logged in.</p>

    <form method="POST">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>






