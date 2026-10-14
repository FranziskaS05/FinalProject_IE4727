<?php

$pageTitle = "Booking Confirmation";

$movie = $_POST["movie"] ?? "";
$name = $_POST["name"] ?? "";
$email = $_POST["email"] ?? "";
$screening = $_POST["screening"] ?? "";
$tickets = $_POST["tickets"] ?? "";

include "includes/header.php";

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

    <a href="shows.php">Back to Movies</a>

</main>

<?php include "includes/footer.php"; ?>