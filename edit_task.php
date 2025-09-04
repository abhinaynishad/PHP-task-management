<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "user_system");

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: dashbord.php");
    exit();
}

// Fetch task
$sql = "SELECT * FROM tasks WHERE id=$id AND user_email='$email'";
$result = mysqli_query($conn, $sql);
$task = mysqli_fetch_assoc($result);

if (!$task) {
    header("Location: dashbord.php");
    exit();
}

// Update Task
if (isset($_POST['update_task'])) {
    $task_name = $_POST['task_name'];
    $task_desc = $_POST['task_desc'];
    $priority  = $_POST['priority'];

    $update = "UPDATE tasks 
               SET task_name='$task_name', task_desc='$task_desc', priority='$priority' 
               WHERE id=$id AND user_email='$email'";
    mysqli_query($conn, $update);

    header("Location: dashbord.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container" style="height:100vh;">
    <h2>Edit Task</h2>
    <form method="POST">
        <p>
            Task Name: <br>
            <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
        </p>
        <p>
            Task Description: <br>
            <textarea name="task_desc"><?php echo htmlspecialchars($task['task_desc']); ?></textarea>
        </p>
        <p>
            Priority: <br>
            <select name="priority">
                <option value="Low" <?php if($task['priority']=="Low") echo "selected"; ?>>Low</option>
                <option value="Medium" <?php if($task['priority']=="Medium") echo "selected"; ?>>Medium</option>
                <option value="High" <?php if($task['priority']=="High") echo "selected"; ?>>High</option>
            </select>
        </p>
      
        <form method="POST"  class="mt-3">
            <button type="submit" name="update_task" class="btn btn-primary">Update Task</button>
        </form>
        <a href="dashbord.php">Cancel??</a>
    </form>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
