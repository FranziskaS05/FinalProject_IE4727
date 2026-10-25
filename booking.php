<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: user.php");
    exit();
}

$movie = $_GET["movie"] ?? $_POST["movie"] ?? "";

if ($movie == "") {
    header("Location: shows.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $screening = $_POST["screening"] ?? "";
    $tickets = (int)($_POST["tickets"] ?? 0);

    // Server-side validation
    if ($name == "") {
        $error = "Please enter your name.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email.";
    } elseif ($tickets < 1) {
        $error = "Please select at least 1 ticket.";
    } else {

        $preference = [
            "movie" => $movie,
            "name" => $name,
            "email" => $email,
            "screening" => $screening,
            "tickets" => $tickets
        ];

        $_SESSION["booking_preferences"][] = $preference;

        header("Location: review.php");
        exit();
    }
}

$pageTitle = "Book Tickets";
include "includes/header.php";
?>

<main>

    <h1>Book Tickets</h1>

    <h2><?php echo htmlspecialchars($movie); ?></h2>

    <?php if ($error != "") { ?>

        <p><?php echo htmlspecialchars($error); ?></p>

    <?php } ?>

    <form action="booking.php" method="post">

        <input
            type="hidden"
            name="movie"
            value="<?php echo htmlspecialchars($movie); ?>"
        >

        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Screening Time:</label>

        <select name="screening" required>

            <?php if ($movie == "Spiderman") { ?>

                <option value="2:00 PM">2:00 PM</option>
                <option value="5:00 PM">5:00 PM</option>
                <option value="8:00 PM">8:00 PM</option>

            <?php } elseif ($movie == "The Sandman") { ?>

                <option value="1:00 PM">1:00 PM</option>
                <option value="4:00 PM">4:00 PM</option>
                <option value="7:00 PM">7:00 PM</option>

            <?php } ?>

        </select>

        <label>Number of Tickets:</label>

        <input
            type="number"
            name="tickets"
            min="1"
            required
        >

        <button type="submit">
            Add Booking Preference
        </button>

    </form>

</main>

<?php include "includes/footer.php"; ?>