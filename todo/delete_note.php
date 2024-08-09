<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM notes WHERE id=$id AND user_id=$user_id";
    $conn->query($sql);
}

$conn->close();
header('Location: home.php');
exit();
?>
