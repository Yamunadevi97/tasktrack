<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        header('Location: login.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
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
   
    <h1>Signup</h1><br><br>
    <h4>Create Your Account</h4>
    <form method="post" action="">
       <label for=""> Username: </label><input type="text" name="username" required><br>
       <label for="">Password:</label>  <input type="password" name="password" required><br>
        <input  class="submit" type="submit" value="Signup">
    </form>
    <p>Already have an account?  <a href="login.php">login</a></p>
</body>
</html>
