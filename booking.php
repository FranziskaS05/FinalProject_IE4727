<?php
session_start();

$movie = $_GET["movie"] ?? "";

if ($movie == "") {
    header("Location: shows.php");
    exit;
}

if (!isset($_SESSION["user_id"])) {
    header("Location: user.php");
    exit();
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

        <div class="mb-3">
            <label class="form-label">Name:</label>

            <input
                type="text"
                name="name"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Email:</label>

            <input
                type="email"
                name="email"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Screening Time:</label>

            <select
                name="screening"
                class="form-select"
                required
            >

                <?php if ($movie == "Spiderman") { ?>

                    <option value="2:00 PM">2:00 PM</option>
                    <option value="5:00 PM">5:00 PM</option>
                    <option value="8:00 PM">8:00 PM</option>

                <?php } elseif ($movie == "The Sandman") { ?>

                    <option value="1:00 PM">1:00 PM</option>
                    <option value="4:00 PM">4:00 PM</option>
                    <option value="7:00 PM">7:00 PM</option>

                <?php } ?>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Number of Tickets:</label>

            <input
                type="number"
                name="tickets"
                min="1"
                class="form-control"
                required
            >
        </div>

        <button
            type="submit"
            class="btn btn-danger"
        >
            Confirm Booking
        </button>

    </form>

</main>

<?php include "includes/footer.php"; ?>