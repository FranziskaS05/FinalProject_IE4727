<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: user.php");
    exit();
}

require_once "includes/db.php";

$preferences = $_SESSION["booking_preferences"] ?? [];
$selected = $_POST["selected"] ?? [];

if (empty($selected)) {
    header("Location: review.php");
    exit();
}

$confirmedBookings = [];

foreach ($preferences as $index => $booking) {

    if (isset($selected[$index])) {

        $userId = $_SESSION["user_id"];
        $movie = $booking["movie"];
        $name = $booking["name"];
        $email = $booking["email"];
        $screening = $booking["screening"];
        $tickets = (int)$booking["tickets"];

        // Save booking into database
        $stmt = $db->prepare(
            "INSERT INTO bookings
            (user_id, movie, name, email, screening, tickets)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "issssi",
            $userId,
            $movie,
            $name,
            $email,
            $screening,
            $tickets
        );

        $stmt->execute();
        $stmt->close();

        // Send email acknowledgement
        $subject = "CinemaHub Booking Confirmation";

        $message =
            "Hi " . $name . ",\n\n" .
            "Your booking has been confirmed.\n\n" .
            "Movie: " . $movie . "\n" .
            "Screening: " . $screening . "\n" .
            "Tickets: " . $tickets . "\n\n" .
            "Thank you for booking with CinemaHub.";

        mail($email, $subject, $message);

        $confirmedBookings[] = $booking;
    }
}

unset($_SESSION["booking_preferences"]);

$pageTitle = "Booking Confirmation";
include "includes/header.php";
?>

<main>

    <h1>Booking Confirmed</h1>

    <?php foreach ($confirmedBookings as $booking) { ?>

        <h2>
            <?php echo htmlspecialchars($booking["movie"]); ?>
        </h2>

        <p>
            <strong>Name:</strong>
            <?php echo htmlspecialchars($booking["name"]); ?>
        </p>

        <p>
            <strong>Email:</strong>
            <?php echo htmlspecialchars($booking["email"]); ?>
        </p>

        <p>
            <strong>Screening:</strong>
            <?php echo htmlspecialchars($booking["screening"]); ?>
        </p>

        <p>
            <strong>Tickets:</strong>
            <?php echo (int)$booking["tickets"]; ?>
        </p>

        <hr>

    <?php } ?>

    <p>
        A booking acknowledgement has been sent to your email.
    </p>

    <a href="profile.php" class="btn-primary">
        Go to Profile
    </a>

</main>

<?php include "includes/footer.php"; ?>