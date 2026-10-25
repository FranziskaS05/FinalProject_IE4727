<?php
$pageTitle = "Movies";
include "includes/header.php";
?>

<main>

    <h1>Now Showing</h1>

     <div class="movie-grid">
 
        <div class="movie">
            <div class="movie-poster">
                <img src="images/spiderman.jpg" alt="Movie 1 poster">
            </div>
 
            <div>
                <h2>Spiderman</h2>
                <p>Action | 120 minutes</p>
                <p>2:00 PM | 5:00 PM | 8:00 PM</p>
            </div>
 
            <a href="booking.php?movie=Spiderman">Book Now</a>
        </div>
 
        <div class="movie">
            <div class="movie-poster">
                <img src="images/sand.jpg" alt="Movie 2 poster">
            </div>
 
            <div>
                <h2>The Sandman</h2>
                <p>Science Fiction | 105 minutes</p>
                <p>1:00 PM | 4:00 PM | 7:00 PM</p>
            </div>
 
            <a href="booking.php?movie=TheSandman">Book Now</a>
        </div>
 
    </div>

</main>

<?php include "includes/footer.php"; ?>