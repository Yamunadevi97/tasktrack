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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql = "DELETE FROM tasks WHERE id=$id";
    $conn->query($sql);
}

$conn->close();
header('Location: home.php');
?>
