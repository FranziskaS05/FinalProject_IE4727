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
?>

<main>

    <h1>Review Booking Preferences</h1>

    <?php if (empty($preferences)) { ?>

        <p>No booking preferences added yet.</p>

        <a href="shows.php">Browse Movies</a>

    <?php } else { ?>

        <form action="confirmation.php" method="post">

            <table>

                <tr>
                    <th>Select</th>
                    <th>Movie</th>
                    <th>Screening</th>
                    <th>Tickets</th>
                </tr>

                <?php foreach ($preferences as $index => $booking) { ?>

                    <tr>

                        <td>
                            <input
                                type="checkbox"
                                name="selected[<?php echo $index; ?>]"
                                value="1"
                                checked
                            >
                        </td>

                        <td>
                            <?php echo htmlspecialchars($booking["movie"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($booking["screening"]); ?>
                        </td>

                        <td>
                            <?php echo (int)$booking["tickets"]; ?>
                        </td>

                    </tr>

                <?php } ?>

            </table>

            <button type="submit">
                Confirm Selected Booking
            </button>

        </form>


        <p>
            <a href="shows.php">
                Add Another Booking Preference
            </a>
        </p>


        <form method="post">

            <button type="submit" name="clear" value="1">
                Clear Preferences
            </button>

        </form>

    <?php } ?>

</main>

<?php include "includes/footer.php"; ?>