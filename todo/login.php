<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: home.php');
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    h1,h4,p{
        margin: auto;
        text-align: center;
    }
    input{
        border-radius: 50px;
        line-height: 2em;
    }
   
</style>
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="">
       <label for=""> Username: </label><input type="text" name="username" required><br>
        <label for="">Password: </label><input type="password" name="password" required><br>
        <input class="submit" type="submit" value="Login">
        <p>Create an account <a class="s" href="index.php">sign up</a></p>
    </form>
</body>
</html>
