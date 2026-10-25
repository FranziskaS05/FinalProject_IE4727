<?php
$pageTitle = "Movies";
include "includes/header.php";
?>

<main>

    <h1>Now Showing</h1>

    <div class="row g-4 mt-3">

        <div class="col-md-6">
            <div class="card h-100 shadow-sm">

                <img
                    src="images/spiderman.jpg"
                    class="card-img-top"
                    alt="Spiderman poster"
                >

                <div class="card-body">
                    <h2 class="card-title">Spiderman</h2>

                    <p class="card-text">
                        Action | 120 minutes
                    </p>

                    <p class="card-text">
                        2:00 PM | 5:00 PM | 8:00 PM
                    </p>

                    <a
                        href="booking.php?movie=Spiderman"
                        class="btn btn-danger"
                    >
                        Book Now
                    </a>
                </div>

            </div>
        </div>


        <div class="col-md-6">
            <div class="card h-100 shadow-sm">

                <img
                    src="images/sand.jpg"
                    class="card-img-top"
                    alt="The Sandman poster"
                >

                <div class="card-body">
                    <h2 class="card-title">The Sandman</h2>

                    <p class="card-text">
                        Science Fiction | 105 minutes
                    </p>

                    <p class="card-text">
                        1:00 PM | 4:00 PM | 7:00 PM
                    </p>

                    <a
                        href="booking.php?movie=The%20Sandman"
                        class="btn btn-danger"
                    >
                        Book Now
                    </a>
                </div>

            </div>
        </div>

    </div>

</main>

<?php include "includes/footer.php"; ?>