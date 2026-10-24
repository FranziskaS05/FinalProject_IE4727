<?php

$pageTitle = "Booking Confirmation";

$movie = $_POST["movie"] ?? "";
$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
$screening = $_POST["screening"] ?? "";
$tickets = (int)$_POST["tickets"] ?? "";

include "includes/header.php";
require_once "includes/db.php";
$stmt = $db->prepare(
    "INSERT INTO bookings (movie, name, email, screening, tickets) VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param("ssssi", $movie, $name, $email, $screening, $tickets);

if ($stmt->execute()) {
    echo "<p>Booking successful!</p>";
} else {
    echo "<p>Booking failed.</p>";
}

$stmt->close();

?>

<main>

    <h1>Booking Confirmed</h1>

    <p>
        <strong>Movie:</strong>
        <?php echo htmlspecialchars($movie); ?>
    </p>

    <p>
        <strong>Name:</strong>
        <?php echo htmlspecialchars($name); ?>
    </p>

    <p>
        <strong>Email:</strong>
        <?php echo htmlspecialchars($email); ?>
    </p>

    <p>
        <strong>Screening:</strong>
        <?php echo htmlspecialchars($screening); ?>
    </p>

    <p>
        <strong>Tickets:</strong>
        <?php echo htmlspecialchars($tickets); ?>
    </p>

    <br>
    <h3> Your can view your bookings in your profile page.</h3>
    <a href="profile.php">Go to Profile</a>

    <a href="shows.php">Back to Movies</a>

</main>

<?php include "includes/footer.php"; ?>