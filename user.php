<?php
include "includes/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register/login</title>
</head>
<body>
    <main> 
        <h2>Login</h2>
        <form action="user.php" method="post">
        <label for="username">Username:</label>
        <input type ="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>         
        <input type="password" id="password" name="password" required>
        <br><br>    
        <input type="submit" name="Login" value="Login">
        </form>
        <h2>Register</h2>
        <form action="user.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <input type="submit" name="Register" value="Register">
            <input type=reset name="Reset" value="Reset">
        </form>
    </main>
</body>
</html>

<?php 
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Register'])) {
     
        $users = json_decode(file_get_contents('users.json'), true);
        if (!isset($users[$username])) {
            $users[$username] = password_hash($password, PASSWORD_DEFAULT);
            file_put_contents('users.json', json_encode($users));
            echo "Registration successful. You can now log in.";
        } else {
            echo "Username already exists. Please choose a different username.";
        }
    }

   
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Login'])) {
      
        $users = json_decode(file_get_contents('users.json'), true);
        if (isset($users[$username]) && password_verify($password, $users[$username])) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: profile.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    }
}
?>