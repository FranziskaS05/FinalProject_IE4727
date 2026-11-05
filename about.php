<?php
session_start();
$pageTitle = "About Us";

$gallery = [
    ["images/gallery/lobby.jpg",   "Our lobby"],
    ["images/gallery/hall1.jpg",   "Screen 1"],
    ["images/gallery/hall2.jpg",   "Screen 2"],
    ["images/gallery/snacks.jpg",  "Snack bar"],
    ["images/gallery/entrance.jpg","Main entrance"],
    ["images/gallery/seats.jpg",   "Comfort seating"],
];

include "includes/header.php";
?>

<main class="container py-5">

    <div class="text-center mb-4">
        <h1>About CinemaHub</h1>
        <p class="lead text-body-secondary mt-3">More than just movies.</p>
    </div>

    <p class="text-center text-body-secondary mx-auto mb-5" style="max-width: 720px;">
        Welcome to our cinema – a place where great stories meet great sound.
        Since opening our doors, we have been bringing blockbusters, indie
        favourites and family films to the big screen in a warm, friendly atmosphere.
    </p>


    <!-- Statistics -->
    <div class="row g-3 mb-5 text-center">

        <div class="col-6 col-md-3">
            <div class="card h-100 py-3">
                <span class="fs-2 fw-bold text-gold">2</span>
                <span class="text-uppercase small text-body-secondary">Screens</span>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 py-3">
                <span class="fs-2 fw-bold text-gold">130</span>
                <span class="text-uppercase small text-body-secondary">Seats</span>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 py-3">
                <span class="fs-2 fw-bold text-gold">2015</span>
                <span class="text-uppercase small text-body-secondary">Since</span>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card h-100 py-3">
                <span class="fs-2 fw-bold text-gold">365</span>
                <span class="text-uppercase small text-body-secondary">Days a year</span>
            </div>
        </div>

    </div>


    <h2 class="text-center mb-4">Why Visit Us</h2>

    <div class="row g-4 mb-5">

        <div class="col-md-4">
            <div class="card feature-card h-100 p-4">
                <h3 class="h5">Premium Sound &amp; Picture</h3>
                <p class="text-body-secondary mb-0">
                    Modern projection and surround sound for the full cinema experience.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card feature-card h-100 p-4">
                <h3 class="h5">Comfortable Seating</h3>
                <p class="text-body-secondary mb-0">
                    Spacious reclining seats with plenty of legroom in every screen.
                </p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card feature-card h-100 p-4">
                <h3 class="h5">Easy Booking</h3>
                <p class="text-body-secondary mb-0">
                    Reserve your tickets online in a few clicks and manage them in your profile.
                </p>
            </div>
        </div>

    </div>


    <h2 class="text-center mb-4">Gallery</h2>

    <div class="row g-3 mb-5">

        <?php foreach ($gallery as $item) { ?>

            <div class="col-sm-6 col-lg-4">
                <figure class="gallery-item position-relative overflow-hidden rounded-4 m-0">

                    <?php if (file_exists($item[0])) { ?>

                        <img
                            src="<?php echo htmlspecialchars($item[0]); ?>"
                            alt="<?php echo htmlspecialchars($item[1]); ?>"
                            loading="lazy"
                        >

                    <?php } else { ?>

                        <div class="gallery-placeholder d-flex align-items-center justify-content-center text-body-secondary">
                            Photo coming soon
                        </div>

                    <?php } ?>

                    <figcaption>
                        <?php echo htmlspecialchars($item[1]); ?>
                    </figcaption>

                </figure>
            </div>

        <?php } ?>

    </div>


    <h2 class="text-center mb-3">Opening Hours</h2>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <table class="table">

                <tr>
                    <th>Day</th>
                    <th>Hours</th>
                </tr>

                <tr>
                    <td>Monday – Friday</td>
                    <td>12:00 – 23:00</td>
                </tr>

                <tr>
                    <td>Saturday – Sunday</td>
                    <td>10:00 – 00:00</td>
                </tr>

            </table>
        </div>
    </div>


    <p class="text-center">
        Questions?
        Write to
        <a href="mailto:info@cinemahub.com">info@CinemaHub.com</a>
        or
        <a href="shows.php">browse our current movies</a>.
    </p>

</main>

<?php include "includes/footer.php"; ?>