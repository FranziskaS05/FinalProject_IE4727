<?php
session_start();
require_once "includes/db.php";

$movies=$db->query("SELECT title, genre, duration, poster, times, price FROM movies");
$pageTitle = "Movies";
include "includes/header.php";
?>

<main>

    <h1>Now Showing</h1>

     <div class="movie-grid">
 <?php while ($movie = $movies->fetch_assoc()) { ?>
        <div class="movie">
            <div class="movie-poster">
                  <img src="<?php echo htmlspecialchars($movie["poster"]); ?>" alt="<?php echo htmlspecialchars($movie["title"]); ?> poster">
            </div>
 
            <div>
                <h2><?php echo htmlspecialchars($movie["title"]); ?></h2>
                <p><?php echo htmlspecialchars($movie["genre"]); ?> | <?php echo htmlspecialchars($movie["duration"]); ?> minutes</p>
                <p><?php echo htmlspecialchars(str_replace(",", " | ",$movie["times"])); ?></p>
                <p>Price: $<?php echo number_format($movie["price"], 2); ?></p>
            </div>
 
            <a href="booking.php?movie=<?php echo urlencode($movie["title"]); ?>">Book Now</a>
        </div>
 
      
      <?php } ?>
    </div>

</main>

<?php include "includes/footer.php"; ?>