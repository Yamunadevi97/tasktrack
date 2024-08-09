<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql = "SELECT * FROM tasks WHERE id=$id AND user_id=" . $_SESSION['user_id'];
    $result = $conn->query($sql);
    $task = $result->fetch_assoc();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $task = $_GET['task'];
    $due_time = $_GET['due_time'];
    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE tasks SET task='$task', due_time='$due_time' WHERE id=$id AND user_id=$user_id";
    $conn->query($sql);
    header('Location: home.php');
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<nav class="navbar">
        <div class="container">
            <a href="#" class="logo">TaskTrack</a>
            <ul class="nav-links">
            <li><span><i class="fa-solid fa-list-check"></i></span><a href="#tasks">Tasks</a></li>
                <li><span><i class="fa-solid fa-note-sticky"></i></span><a href="add_notes.php">Notes</a></li>
                <li><a href="logout.php"><span><i class="fa-solid fa-power-off"></i></span>Logout</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </div>
    </nav>
    <h1>Edit Task</h1>
    <form method="get" action="">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
       <label for="">Task: </label> <input type="text" name="task" value="<?php echo $task['task']; ?>" required><br>
       <label for=""> Due Time: </label><input type="datetime-local" name="due_time" value="<?php echo date('Y-m-d\TH:i', strtotime($task['due_time'])); ?>" required><br>
        <input class="submit" type="submit" value="Update Task">
    </form>
   </body>
</html>
