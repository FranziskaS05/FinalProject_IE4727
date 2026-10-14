<?php

$movie = $_GET["movie"] ?? "";

if ($movie == "") {
    header("Location: shows.php");
    exit;
}

$pageTitle = "Book Tickets";
include "includes/header.php";

?>

<main>

    <h1>Book Tickets</h1>

    <h2><?php echo htmlspecialchars($movie); ?></h2>

    <form action="confirmation.php" method="post">

        <input
            type="hidden"
            name="movie"
            value="<?php echo htmlspecialchars($movie); ?>"
        >


        <label>Name:</label>
        <input type="text" name="name" required>

        <br><br>


        <label>Email:</label>
        <input type="email" name="email" required>

        <br><br>


        <label>Screening Time:</label>

        <select name="screening" required>

            <?php if ($movie == "Movie 1") { ?>

                <option value="2:00 PM">2:00 PM</option>
                <option value="5:00 PM">5:00 PM</option>
                <option value="8:00 PM">8:00 PM</option>

            <?php } else { ?>

                <option value="1:00 PM">1:00 PM</option>
                <option value="4:00 PM">4:00 PM</option>
                <option value="7:00 PM">7:00 PM</option>

            <?php } ?>

        </select>

        <br><br>


        <label>Number of Tickets:</label>

        <input
            type="number"
            name="tickets"
            min="1"
            required
        >

        <br><br>


        <button type="submit">
            Confirm Booking
        </button>

    </form>

</main>

<?php include "includes/footer.php"; ?>