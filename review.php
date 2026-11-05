<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: user.php");
    exit();
}

if (isset($_POST["clear"])) {
    unset($_SESSION["booking_preferences"]);
    header("Location: review.php");
    exit();
}

$preferences = $_SESSION["booking_preferences"] ?? [];

$pageTitle = "Review Bookings";
include "includes/header.php";
include "movies.php";
?>

<main class="container py-5">

    <h1 class="text-center mb-5">Review Booking Preferences</h1>

    <?php if (empty($preferences)) { ?>

        <div class="text-center">
            <p>No booking preferences added yet.</p>
            <a href="shows.php" class="btn btn-danger">Browse Movies</a>
        </div>

    <?php } else { ?>

        <form action="confirmation.php" method="post" onsubmit="return checkReview();">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Movie</th>
                            <th>Screening</th>
                            <th>Tickets</th>
                            <th>Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($preferences as $index => $booking) { ?>

                            <tr>
                                <td>
                                    <input
                                        type="checkbox"
                                        name="selected[<?php echo $index; ?>]"
                                        value="1"
                                        class="form-check-input"
                                        checked
                                    >
                                </td>
                                <td><?php echo htmlspecialchars($booking["movie"]); ?></td>
                                <td><?php echo htmlspecialchars($booking["screening"]); ?></td>
                                <td><?php echo (int)$booking["tickets"]; ?></td>
                                <td>$<?php echo number_format(total_price($db, $booking["movie"], $booking["tickets"]), 2); ?></td>
                            </tr>

                        <?php } ?>
                    </tbody>

                </table>
            </div>

            <button type="submit" class="btn btn-danger">
                Confirm Selected Booking
            </button>

            <a href="shows.php" class="btn btn-outline-light ms-2">
                Add Another Booking Preference
            </a>

        </form>

        <form method="post" class="mt-3">
            <button type="submit" name="clear" value="1" class="btn btn-outline-secondary btn-sm">
                Clear Preferences
            </button>
        </form>

    <?php } ?>

</main>
<script src="includes/functions.js"></script>
<?php include "includes/footer.php"; ?>