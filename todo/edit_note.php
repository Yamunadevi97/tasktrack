<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql = "SELECT * FROM notes WHERE id=$id AND user_id=" . $_SESSION['user_id'];
    $result = $conn->query($sql);
    $note = $result->fetch_assoc();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $note = $_GET['note'];
    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE notes SET note='$note' WHERE id=$id AND user_id=$user_id";
    $conn->query($sql);
    header('Location: home.php');
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Note</title>
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
    <h1>Edit Note</h1>
    <form method="get" action="">
        <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
     <label for=""> Note: </label>  <textarea name="note" required><?php echo $note['note']; ?></textarea><br>
        <input class="submit" type="submit" value="Update Note">
    </form>
   </body>
</html>
