<?php
session_start();
require_once "includes/db.php";

$movies=$db->query("SELECT title, genre, duration, poster, times, price FROM movies");
$pageTitle = "Movies";
include "includes/header.php";
?>

<main class="container py-5">

    <h1 class="text-center mb-5">Now Showing</h1>

    <div class="row g-4">

        <?php while ($movie = $movies->fetch_assoc()) { ?>

            <div class="col-lg-6">
                <div class="card h-100 shadow overflow-hidden">
                    <div class="row g-0 h-100">

                        <div class="col-sm-5">
                            <img
                                src="<?php echo htmlspecialchars($movie["poster"]); ?>"
                                alt="<?php echo htmlspecialchars($movie["title"]); ?> poster"
                                class="movie-poster"
                            >
                        </div>

                        <div class="col-sm-7">
                            <div class="card-body d-flex flex-column h-100">
                                <h2 class="card-title h4"><?php echo htmlspecialchars($movie["title"]); ?></h2>
                                <p class="text-body-secondary mb-1"><?php echo htmlspecialchars($movie["genre"]); ?> | <?php echo htmlspecialchars($movie["duration"]); ?> minutes</p>
                                <p class="text-body-secondary mb-1"><?php echo htmlspecialchars(str_replace(",", " | ",$movie["times"])); ?></p>
                                <p class="text-body-secondary">Price: $<?php echo number_format($movie["price"], 2); ?></p>

                                <a href="booking.php?movie=<?php echo urlencode($movie["title"]); ?>" class="btn btn-danger mt-auto align-self-start">Book Now</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        <?php } ?>

    </div>

</main>

<?php include "includes/footer.php"; ?>
