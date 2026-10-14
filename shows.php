<?php
$pageTitle = "Movies";
include "includes/header.php";
?>

<main>

    <h1>Now Showing</h1>

    <div class="movie">
        <h2>Movie 1</h2>

        <p>Action | 120 minutes</p>

        <p>2:00 PM | 5:00 PM | 8:00 PM</p>

        <a href="booking.php?movie=Movie%201">Book Now</a>
    </div>


    <div class="movie">
        <h2>Movie 2</h2>

        <p>Comedy | 105 minutes</p>

        <p>1:00 PM | 4:00 PM | 7:00 PM</p>

        <a href="booking.php?movie=Movie%202">Book Now</a>
    </div>

</main>

<?php include "includes/footer.php"; ?>