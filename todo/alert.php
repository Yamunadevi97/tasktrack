<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todolist";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$current_time = date('Y-m-d H:i:s');
$alert_time = date('Y-m-d H:i:s', strtotime('+5 minutes'));

$sql = "SELECT * FROM tasks WHERE due_time <= '$alert_time' AND due_time > '$current_time' AND alert_shown = FALSE";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()) {
    echo "Alert: Task '" . $row['task'] . "' is due at " . $row['due_time'] . ".<br>";
    $update_sql = "UPDATE tasks SET alert_shown = TRUE WHERE id = " . $row['id'];
    $conn->query($update_sql);
}

$conn->close();
?>
