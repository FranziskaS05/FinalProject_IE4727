<?php
session_start();
 
if (!isset($_SESSION["user_id"])) {
    header("Location: user.php");
    exit();
}
 
require_once "includes/db.php";
include "movies.php";
 
$movie = $_GET["movie"] ?? $_POST["movie"] ?? "";
 
$m = get_movie($db, $movie);
 
if (!$m) {
    header("Location: shows.php");
    exit();
}
 
$error = "";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $screening = $_POST["screening"] ?? "";
    $tickets = (int)($_POST["tickets"] ?? 0);
 
    
    if ($name == "") {
        $error = "Please enter your name.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match('/^[A-Za-z0-9._-]+@localhost$/', $email)) {
        $error = "Please enter a valid email.";
    } elseif (!in_array($screening, $m["times"])) {
        $error = "Please choose a valid screening time.";
    } elseif ($tickets < 1 || $tickets > 10) {
        $error = "Tickets must be between 1 and 10.";
    } else {
 
        $_SESSION["booking_preferences"][] = [
            "movie" => $movie,
            "name" => $name,
            "email" => $email,
            "screening" => $screening,
            "tickets" => $tickets
        ];
 
        header("Location: review.php");
        exit();
    }
}
 
$pageTitle = "Book Tickets";
include "includes/header.php";
?>
 
<main class="container py-5">

    <h1 class="text-center mb-5">Book Tickets</h1>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow p-4">

                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="<?php echo htmlspecialchars($m["poster"]); ?>" alt="Poster" width="90" class="rounded">
                    <div>
                        <h2 class="h4 mb-1"><?php echo htmlspecialchars($m["title"]); ?></h2>
                        <p class="text-body-secondary mb-0">Price: $<?php echo number_format($m["price"], 2); ?> per ticket</p>
                    </div>
                </div>

                <?php if ($error != "") { ?>
                    <div class="alert alert-warning"><?php echo htmlspecialchars($error); ?></div>
                <?php } ?>

                <form action="booking.php" method="post" onsubmit="return checkBooking();">

                    <input type="hidden" name="movie" value="<?php echo htmlspecialchars($m["title"]); ?>">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="screening" class="form-label">Screening Time:</label>
                            <select id="screening" name="screening" class="form-select" required>
                                <?php foreach ($m["times"] as $t) { ?>
                                    <option value="<?php echo htmlspecialchars($t); ?>"><?php echo htmlspecialchars($t); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label for="tickets" class="form-label">Number of Tickets:</label>
                            <input type="number" id="tickets" name="tickets" min="1" max="10" class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-danger w-100">Add Booking Preference</button>

                </form>

            </div>
        </div>
    </div>

</main>
 
<script src="includes/functions.js"></script>
 
<?php include "includes/footer.php"; ?>
 
