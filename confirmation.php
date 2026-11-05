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

<main class="container py-5">

    <h1 class="text-center mb-5"><?php echo empty($confirmedBookings) ? "Booking Failed" : "Booking Confirmed"; ?></h1>

    <?php if ($failedBookings > 0) { ?>
        <div class="alert alert-warning">
            <?php echo $failedBookings; ?> booking(s) could not be saved. Please try again.
        </div>
    <?php } ?>

    <div class="row g-4 justify-content-center">

        <?php foreach ($confirmedBookings as $booking) { ?>

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow">
                    <div class="card-body">

                        <h2 class="card-title h4 text-gold">
                            <?php echo htmlspecialchars($booking["movie"]); ?>
                        </h2>

                        <p class="mb-1">
                            <strong>Name:</strong>
                            <?php echo htmlspecialchars($booking["name"]); ?>
                        </p>

                        <p class="mb-1">
                            <strong>Email:</strong>
                            <?php echo htmlspecialchars($booking["email"]); ?>
                        </p>

                        <p class="mb-1">
                            <strong>Screening:</strong>
                            <?php echo htmlspecialchars($booking["screening"]); ?>
                        </p>

                        <p class="mb-1">
                            <strong>Tickets:</strong>
                            <?php echo (int)$booking["tickets"]; ?>
                        </p>

                        <p class="mb-0">
                            <strong>Total Price:</strong>
                            $<?php echo number_format(total_price($db, $booking["movie"], $booking["tickets"]), 2); ?>
                        </p>

                    </div>
                </div>
            </div>

        <?php } ?>

    </div>

    <div class="text-center mt-4">

        <?php if (!empty($confirmedBookings)) { ?>
            <p class="fs-5">
                <strong>Grand Total:</strong>
                $<?php echo number_format($grandTotal, 2); ?>
            </p>

            <?php if ($mailFailed) { ?>
                <div class="alert alert-warning d-inline-block">
                    Your booking is saved, but the acknowledgement email could not be sent.
                </div>
            <?php } else { ?>
                <div class="alert alert-success d-inline-block">
                    A booking acknowledgement has been sent to your email.
                </div>
            <?php } ?>
        <?php } ?>

        <div>
            <a href="profile.php" class="btn btn-danger mt-2">
                Go to Profile
            </a>
        </div>

    </div>

</main>

<?php include "includes/footer.php"; ?>