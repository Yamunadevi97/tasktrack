<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_task'])) {
        $task = $_POST['task'];
        $due_time = $_POST['due_time'];
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO tasks (user_id, task, due_time) VALUES ('$user_id', '$task', '$due_time')";
        if ($conn->query($sql) === TRUE) {
            // Task added successfully, optionally redirect or show success message
            header('Location: index.php'); // Redirect to index.php after adding task
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Fetch all tasks for the logged-in user
$sql_tasks = "SELECT * FROM tasks WHERE user_id=" . $_SESSION['user_id'];
$result_tasks = $conn->query($sql_tasks);

$tasks = [];
while ($row = $result_tasks->fetch_assoc()) {
    $tasks[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>To-Do List and Notes</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  
</style>
</head>
<body>
    <header>
     
        <nav class="navbar">
        <div class="container">
            <a href="#" class="logo">TaskTrack</a>
            <ul class="nav-links">
            <li><a href="#tasks"><i class="fa-solid fa-list-check"></i> Tasks</a></li>
                <li><a href="add_notes.php"><i class="fa-solid fa-note-sticky"></i> Notes</a></li>
                <li><a href="logout.php"><i class="fa-solid fa-power-off"></i> Logout</a></li>
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </div>
    </nav>
    </header>

    <div id="tasks" class="section">
       <center><h1>To-Do List</h1></center> 
        <form method="post" action="">
            <h2>Add Task</h2>
            <label for="">Task: </label><input type="text" name="task" required><br>
          <label for="">Due Time: </label>  <input type="datetime-local" name="due_time" required><br>
            <input class="submit" type="submit" name="add_task" value="Add Task">
        </form>

        <h2>Tasks</h2>
        <ul id="task-list">
            <?php foreach ($tasks as $task) { ?>
                <li data-due-time="<?php echo $task['due_time']; ?>">
                    <?php echo $task['task'] . " - " . $task['due_time']; ?>
                    <form method="post" action="edit.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>"><br>
                        <center><span><i class="fa-solid fa-pen-to-square"></i></center></span>
                        <input type="submit" value="Edit" style="color:black;">
                    </form>
                    <form method="post" action="delete.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>"><br>
                        <center><span ><i class="fa-solid fa-trash-can"></i></span></center>
                        <input type="submit" value="Delete" style="color:black;">
                    </form>
                </li>
            <?php } ?>
        </ul>
    </div>

   

    <audio id="alert-sound" src="stop.mp3" preload="auto"></audio>
    <script>
      function checkTasks() {
    var tasks = document.querySelectorAll('#task-list li');
    var now = new Date();
    var alertSound = document.getElementById('alert-sound');

    tasks.forEach(function(task) {
        var dueTime = new Date(task.getAttribute('data-due-time'));
        var timeDiff = (dueTime - now) / 1000; // time difference in seconds

        if (timeDiff > 0 && timeDiff <= 300) { // within the next 5 minutes
            alertSound.play();
            // Optionally, display an alert message
            alert('Task "' + task.innerText.trim() + '" is ending soon!');
        }
    });
}

setInterval(checkTasks, 60000); // Check every minute
checkTasks(); // Initial check when page loads

    </script>
</body>
</html>
