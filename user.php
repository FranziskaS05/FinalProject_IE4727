<?php
session_start();

require_once "includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username == "" || $password == "") {

        $message = "Please enter a username and password.";
        

    }  elseif (isset($_POST["Register"]) && strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";
    } elseif (isset($_POST["Register"]) && $password !== ($_POST["confirm"] ?? "")) {
        $message = "Passwords do not match.";
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


<main class="container py-5">

    <?php if ($message != "") { ?>
        <div class="alert alert-info text-center">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php } ?>

    <div class="row g-4 justify-content-center">

        <div class="col-md-6 col-lg-5">
            <div class="card shadow p-4 h-100">

                <h2 class="h4 mb-3">Login</h2>

                <form action="user.php" method="post">

                    <div class="mb-3">
                        <label for="login_username" class="form-label">Username:</label>
                        <input type="text" id="login_username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="login_password" class="form-label">Password:</label>
                        <input type="password" id="login_password" name="password" class="form-control" required>
                    </div>

                    <input type="submit" name="Login" value="Login" class="btn btn-danger w-100">

                </form>

            </div>
        </div>

        <div class="col-md-6 col-lg-5">
            <div class="card shadow p-4 h-100">

                <h2 class="h4 mb-3">Register</h2>

                <form action="user.php" method="post" onsubmit="return checkRegister();">

                    <div class="mb-3">
                        <label for="reg_username" class="form-label">Username:</label>
                        <input type="text" id="reg_username" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="reg_password" class="form-label">Password:</label>
                        <input type="password" id="reg_password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="reg_confirm" class="form-label">Confirm password:</label>
                        <input type="password" id="reg_confirm" name="confirm" class="form-control" required>
                    </div>

                    <div class="d-flex gap-2">
                        <input type="submit" name="Register" value="Register" class="btn btn-danger flex-fill">
                        <input type="reset" value="Reset" class="btn btn-outline-secondary">
                    </div>

                </form>

            </div>
        </div>

    </div>

</main>


<script src="includes/functions.js"></script>
<?php include "includes/footer.php"; ?>