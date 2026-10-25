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

<main>


    <div class="about-hero">
        <div class="about-hero-text">
            <h1>About CinemaHub</h1>
            <p>More than just movies.</p>
        </div>
    </div>


    <p class="about-intro">
        Welcome to our cinema – a place where great stories meet great sound.
        Since opening our doors, we have been bringing blockbusters, indie
        favourites and family films to the big screen in a warm, friendly atmosphere.
    </p>


    <!-- Statistics -->
    <section class="stats">

        <div class="stat">
            <span class="stat-number">2</span>
            <span class="stat-label">Screens</span>
        </div>

        <div class="stat">
            <span class="stat-number">130</span>
            <span class="stat-label">Seats</span>
        </div>

        <div class="stat">
            <span class="stat-number">2015</span>
            <span class="stat-label">Since</span>
        </div>

        <div class="stat">
            <span class="stat-number">365</span>
            <span class="stat-label">Days a year</span>
        </div>

    </section>


    <h2>Why Visit Us</h2>

    <section class="about-features">

        <div class="about-card">
            <h3>Premium Sound &amp; Picture</h3>
            <p>
                Modern projection and surround sound for the full cinema experience.
            </p>
        </div>

        <div class="about-card">
            <h3>Comfortable Seating</h3>
            <p>
                Spacious reclining seats with plenty of legroom in every screen.
            </p>
        </div>

        <div class="about-card">
            <h3>Easy Booking</h3>
            <p>
                Reserve your tickets online in a few clicks and manage them in your profile.
            </p>
        </div>

    </section>


    <h2>Gallery</h2>

    <section class="gallery">

        <?php foreach ($gallery as $item) { ?>

            <figure class="gallery-item">

                <?php if (file_exists($item[0])) { ?>

                    <img
                        src="<?php echo htmlspecialchars($item[0]); ?>"
                        alt="<?php echo htmlspecialchars($item[1]); ?>"
                        loading="lazy"
                    >

                <?php } else { ?>

                    <div class="gallery-placeholder">
                        Photo coming soon
                    </div>

                <?php } ?>

                <figcaption>
                    <?php echo htmlspecialchars($item[1]); ?>
                </figcaption>

            </figure>

        <?php } ?>

    </section>


    <h2>Opening Hours</h2>

    <table class="hours">

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


    <p>
        Questions?
        Write to
        <a href="mailto:info@cinemahub.com">
            info@CinemaHub.com
        </a>

        or

        <a href="shows.php">
            browse our current movies
        </a>.
    </p>

</main>

<?php include "includes/footer.php"; ?>