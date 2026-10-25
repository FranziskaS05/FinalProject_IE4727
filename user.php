<?php
session_start();
require_once "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (isset($_POST["Register"])) {

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
                "INSERT INTO users (username, password) VALUES (?, ?)"
            );
            $stmt->bind_param("ss", $username, $hash);
            $stmt->execute();

            $message = "Registration successful. You can now log in.";
        }

        $stmt->close();
    }


    if (isset($_POST["Login"])) {

        $stmt = $db->prepare(
            "SELECT id, password FROM users WHERE username = ?"
        );
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userId, $hash);

        if ($stmt->fetch() && password_verify($password, $hash)) {

            session_regenerate_id(true);

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

    <?php if ($message !== "") { ?>

        <div class="alert alert-info">
            <?php echo htmlspecialchars($message); ?>
        </div>

    <?php } ?>


    <h2>Login</h2>

    <form action="user.php" method="post">

        <div class="mb-3">

            <label for="login_username" class="form-label">
                Username:
            </label>

            <input
                type="text"
                id="login_username"
                name="username"
                class="form-control"
                required
            >

        </div>


        <div class="mb-3">

            <label for="login_password" class="form-label">
                Password:
            </label>

            <input
                type="password"
                id="login_password"
                name="password"
                class="form-control"
                required
            >

        </div>


        <button
            type="submit"
            name="Login"
            class="btn btn-danger"
        >
            Login
        </button>

    </form>


    <h2>Register</h2>

    <form action="user.php" method="post">

        <div class="mb-3">

            <label for="register_username" class="form-label">
                Username:
            </label>

            <input
                type="text"
                id="register_username"
                name="username"
                class="form-control"
                required
            >

        </div>


        <div class="mb-3">

            <label for="register_password" class="form-label">
                Password:
            </label>

            <input
                type="password"
                id="register_password"
                name="password"
                class="form-control"
                required
            >

        </div>


        <button
            type="submit"
            name="Register"
            class="btn btn-danger"
        >
            Register
        </button>

        <button
            type="reset"
            class="btn btn-secondary"
        >
            Reset
        </button>

    </form>

</main>

<?php include "includes/footer.php"; ?>