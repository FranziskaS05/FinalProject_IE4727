
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
    } elseif (!preg_match('/^[^@\s]+@[^@\s]+$/', $email)) {
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
 
<main>
 
    <h1>Book Tickets</h1>
 
    <img src="<?php echo htmlspecialchars($m["poster"]); ?>" alt="Poster" width="150">
 
    <h2><?php echo htmlspecialchars($m["title"]); ?></h2>
 
    <p>Price: $<?php echo number_format($m["price"], 2); ?> per ticket</p>
 
    <?php if ($error != "") { ?>
        <p class="message"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>
 
    <form action="booking.php" method="post" onsubmit="return checkBooking();">
 
        <input type="hidden" name="movie" value="<?php echo htmlspecialchars($m["title"]); ?>">
 
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
 
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
 
        <label for="screening">Screening Time:</label>
        <select id="screening" name="screening" required>
            <?php foreach ($m["times"] as $t) { ?>
                <option value="<?php echo htmlspecialchars($t); ?>"><?php echo htmlspecialchars($t); ?></option>
            <?php } ?>
        </select>
 
        <label for="tickets">Number of Tickets:</label>
        <input type="number" id="tickets" name="tickets" min="1" max="10" required>
 
        <button type="submit">Add Booking Preference</button>
 
    </form>
 
</main>
 
<script src="js/validate.js"></script>
 
<?php include "includes/footer.php"; ?>
 
