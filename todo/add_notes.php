
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'config.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['add_note'])) {
        $note = $_POST['note'];
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO notes (user_id, note) VALUES ('$user_id', '$note')";
        $conn->query($sql);
    } elseif (isset($_POST['update_note'])) {
        $id = $_POST['id'];
        $note = $_POST['note'];
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE notes SET note='$note' WHERE id=$id AND user_id=$user_id";
        $conn->query($sql);
    } elseif (isset($_POST['download_note'])) {
        $id = $_POST['id'];
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM notes WHERE id=$id AND user_id=$user_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $filename = "note_" . $row['id'] . ".txt";
            $note_content = $row['note'];

            // Output file as download
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            echo $note_content;
            exit();
        }
    }
}

// Fetch all tasks and notes for the logged-in user


$sql_notes = "SELECT * FROM notes WHERE user_id=" . $_SESSION['user_id'];
$result_notes = $conn->query($sql_notes);

$notes = [];
while ($row = $result_notes->fetch_assoc()) {
    $notes[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title> Notes</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
    <nav class="navbar">
        <div class="container">
            <a href="#" class="logo">TaskTrack</a>
            <ul class="nav-links">
            <li><a href="home.php"><i class="fa-solid fa-list-check"></i> Tasks</a></li>
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

   
    <div id="notes" class="section">
        <h1>Notes</h1>
        <form method="post" action="">
            <h2>Add Note</h2>
            <label for="">Note: </label><textarea name="note" required></textarea><br>
            <input class="submit" type="submit" name="add_note" value="Add Note">
        </form>

        <h2>Notes</h2>
        <ul>
            <?php foreach ($notes as $note) { ?>
                <li>
                    <?php echo $note['note'] . " - " . $note['created_at']; ?>
                    <form method="post" action="">
                        <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
                        <center><i class="fa-solid fa-download"></i></center>
                        <input type="submit" name="download_note" value="Download">
                    </form>
                    <form method="post" action="edit_note.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
                        <center><i class="fa-solid fa-pen-to-square"></i></center>
                        <input type="submit" value="Edit">
                    </form>
                    <form method="post" action="delete_note.php" style="display:inline;">
                        <center><i class="fa-solid fa-trash-can"></i></center>
                        <input type="hidden" name="id" value="<?php echo $note['id']; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </li>
            <?php } ?>
        </ul>
    </div>
                <script>document.querySelector('.burger').addEventListener('click', () => {
    document.querySelector('.nav-links').classList.toggle('active');
    document.querySelector('.burger').classList.toggle('active');
});
</script>
   </body>
</html>

