<?php
session_start();

require_once "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username == "" || $password == "") {

        $message = "Please enter a username and password.";

    } elseif (isset($_POST["Register"])) {

        $stmt = $db->prepare(
            "SELECT id FROM users WHERE username = ?"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            $message = "Username already exists.";

        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $db->prepare(
                "INSERT INTO users (username, password)
                VALUES (?, ?)"
            );

            $stmt->bind_param("ss", $username, $hash);
            $stmt->execute();

            $message = "Registration successful. You can now log in.";
        }

        $stmt->close();

    } elseif (isset($_POST["Login"])) {

        $stmt = $db->prepare(
            "SELECT id, password FROM users WHERE username = ?"
        );

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $stmt->bind_result($userId, $hash);

        if ($stmt->fetch() && password_verify($password, $hash)) {

            $_SESSION["user_id"] = $userId;
            $_SESSION["username"] = $username;

            header("Location: profile.php");
            exit();

        } else {

            $message = "Invalid username or password.";
        }

        $stmt->close();
    }
}

$pageTitle = "Login";
include "includes/header.php";
?>

<main>

    <?php if ($message != "") { ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php } ?>


    <h2>Login</h2>

    <form action="user.php" method="post">

        <label>Username:</label>
        <input type="text" name="username" required>

        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>

        <br><br>

        <input type="submit" name="Login" value="Login">

    </form>


    <h2>Register</h2>

    <form action="user.php" method="post">

        <label>Username:</label>
        <input type="text" name="username" required>

        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>

        <br><br>

        <input type="submit" name="Register" value="Register">

        <input type="reset" value="Reset">

    </form>

</main>

<?php include "includes/footer.php"; ?>