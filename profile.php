<?php
$pageTitle="Profile";
include "includes/header.php";
?>
<main>
    <h1>User Profile</h1>
    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
    <h3>Your bookings:</h3>
</main>

<?php include "includes/footer.php"; ?>