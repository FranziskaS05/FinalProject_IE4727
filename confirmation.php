<?php
session_start();
$pageTitle = "Booking Confirmation";

require_once "includes/db.php";
$movie = $_POST["movie"] ?? "";
$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
$screening = $_POST["screening"] ?? "";
$tickets = (int)$_POST["tickets"] ?? "";


if (!isset($_SESSION["user_id"])) {
    header("Location: user.php");
    exit();
}
$userId = $_SESSION["user_id"];

$stmt = $db->prepare(
    "INSERT INTO bookings (user_id, movie, name, email, screening, tickets) VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("issssi", $userId, $movie, $name, $email, $screening, $tickets);

if ($stmt->execute()) {
    echo "<p>Booking successful!</p>";
} else {
    echo "<p>Booking failed.</p>";
}

$stmt->close();

?>
<?php include "includes/header.php";?>
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
    <a href="profile.php" class="btn-primary">Go to Profile</a>

    <a href="shows.php" class="btn-secondary">Back to Movies</a>

</main>

<?php include "includes/footer.php"; ?>