<?php
session_start();
require_once "includes/db.php";
include "includes/header.php";

$message = "";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
 
    if (isset($_POST["Register"])) {
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            $message = "Username already exists. Please choose a different username.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hash);
            $stmt->execute();
            $message = "Registration successful. You can now log in.";
        }
        $stmt->close();
    }
}
if (isset($_POST["Login"])) {
        $stmt = $db->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userId, $hash);
 
        if ($stmt->fetch() && password_verify($password, $hash)) {
            session_regenerate_id(true);
            $_SESSION["user_id"]  = $userId;     
            $_SESSION["username"] = $username;
            header("Location: profile.php");
            exit();
        } else {
            $message = "Invalid username or password.";
        }
        $stmt->close();
    }

?>


    <main> 
        <?php if ($message !== "") { ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php } ?>
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


<?php include "includes/footer.php"; ?>