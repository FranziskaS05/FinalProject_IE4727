<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: user.php");
    exit();
}

require_once "includes/db.php";
include "movies.php";

$preferences = $_SESSION["booking_preferences"] ?? [];
$selected = $_POST["selected"] ?? [];

if (empty($selected) || empty($preferences)) {
    header("Location: review.php");
    exit();
}

$confirmedBookings = [];
$grandTotal = 0;
$failedBookings = 0;
$mailFailed = false;

foreach ($preferences as $index => $booking) {

    if (isset($selected[$index])) {

        $userId = $_SESSION["user_id"];
        $movie = $booking["movie"];
        $name = $booking["name"];
        $email = $booking["email"];
        $screening = $booking["screening"];
        $tickets = (int)$booking["tickets"];
        $total= total_price($db, $movie, $tickets);
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

        $saved = $stmt->execute();
        $stmt->close();

        if (!$saved) {
            $failedBookings++;
            continue;
        }

        $subject = "CinemaHub Booking Confirmation";

        $message =
            "Hi " . $name . ",\n\n" .
            "Your booking has been confirmed.\n\n" .
            "Movie: " . $movie . "\n" .
            "Screening: " . $screening . "\n" .
            "Tickets: " . $tickets . "\n\n" .
            "Total Price: $" . number_format($total, 2) . "\n\n" .
            "Thank you for booking with CinemaHub.";

        if (!mail($email, $subject, $message)) {
            $mailFailed = true;
        }

        $confirmedBookings[] = $booking;
        $grandTotal += $total;
    }
}

unset($_SESSION["booking_preferences"]);

$pageTitle = "Booking Confirmation";
include "includes/header.php";
?>

<main>

    <h1><?php echo empty($confirmedBookings) ? "Booking Failed" : "Booking Confirmed"; ?></h1>

    <?php if ($failedBookings > 0) { ?>
        <p class="message">
            <?php echo $failedBookings; ?> booking(s) could not be saved. Please try again.
        </p>
    <?php } ?>

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
        <p>
            <strong>Total Price:</strong>
            $<?php echo number_format(total_price($db, $booking["movie"], $booking["tickets"]), 2); ?>
        </p>

        <hr>

    <?php } ?>

    <?php if (!empty($confirmedBookings)) { ?>
        <p>
            <strong>Grand Total:</strong>
            $<?php echo number_format($grandTotal, 2); ?>
        </p>

        <p>
            <?php if ($mailFailed) { ?>
                Your booking is saved, but the acknowledgement email could not be sent.
            <?php } else { ?>
                A booking acknowledgement has been sent to your email.
            <?php } ?>
        </p>
    <?php } ?>

    <a href="profile.php" class="btn-primary">
        Go to Profile
    </a>

</main>

<?php include "includes/footer.php"; ?>