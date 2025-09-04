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

// add task
if(isset($_POST['addtask'])){
    $task_name = $_POST['task_name'];
    $task_desc = $_POST['task_desc'];
    $priority = $_POST['priority'];

    $insert = "INSERT INTO tasks (user_email,task_name,task_desc,priority) 
               VALUES ('$email','$task_name','$task_desc','$priority')";
    mysqli_query($conn,$insert);
    header("Location: dashbord.php");
    exit();
}

// delete task 
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $delete = "DELETE FROM tasks WHERE id=$id AND user_email='$email'";
    mysqli_query($conn,$delete);
    header("Location: dashbord.php");
    exit();
}

// search box
if (isset($_POST['search'])) {
    $search = $_POST['search_task'];
    $query = "SELECT * FROM tasks 
              WHERE user_email='$email' 
              AND (task_name LIKE '%$search%' OR task_desc LIKE '%$search%'  OR priority LIKE '%$search%')";
              
} else {
    $query = "SELECT * FROM tasks WHERE user_email='$email'";
}
$task = mysqli_query($conn, $query);
?> 
<?php include 'nav.php'?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container" style="height:100vh;">
      <div class="user" style="margin-top: 20vh; justify-content: center; align-items: center; display: flex;">
      <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?> 👋</h1>
      </div>

    <div id="Welcome" class="collapse">
       
        <a href="profile.php" class="btn btn-primary mt-3">View Profile</a>

        <form method="POST" action="logout.php" class="mt-3">
            <button type="submit" name="logout" class="btn btn-danger">Logout</button>
        </form>
    </div>
         
 
    <!-- Add Task -->
    <div class="row collapse" id="add_task">
        <div class="col">
            <h3>Add New Task</h3>
            <form method="post">
                <p>
                    Task Name:
                    <input type="text" name="task_name" required>
                </p>
                <p>
                    Task Desc:
                    <textarea name="task_desc" required></textarea>
                </p>
                <p>
                    Priority:
                    <select name="priority" required>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </p>
                <button type="submit" name="addtask" class="btn btn-success">Add Task</button>
            </form>
       
        <!-- <div class="col">
        <h3>Search Task</h3>
        <form method="post">
            <input type="text" name="search_task" placeholder="Search" class="form-control mb-2">
            <button type="submit" name="search" class="btn btn-primary">Search</button>
        </form>
    </div> -->
    </div>

    <hr>
  
    <!-- Task List -->
    <h3>Your Task</h3>
    <table border="1" cellpadding="4" cellspacing="0" class="table table-bordered">
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Priority</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($task)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['task_name']); ?></td>
            <td><?php echo htmlspecialchars($row['task_desc']); ?></td>
            <td><?php echo htmlspecialchars($row['priority']); ?></td>
            <td>
                <a href="edit_task.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="dashbord.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
     </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
