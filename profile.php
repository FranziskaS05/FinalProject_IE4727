<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: user.php");
    exit();
}
require_once "includes/db.php";

$stmt=$db->prepare("SELECT id, movie, screening, tickets FROM bookings WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$pageTitle="Profile";
include "includes/header.php";
?>
<main>
    <h1>User Profile</h1>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <h3>Your bookings:</h3>
    <?php if ($result->num_rows === 0) { ?>
 
        <p>You have no bookings yet.</p>
 
    <?php } else { ?>
 
        <table border="1" cellpadding="6">
            <tr>
                <th>Booking #</th>
                <th>Movie</th>
                <th>Screening</th>
                <th>Tickets</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo (int)$row["id"]; ?></td>
                    <td><?php echo htmlspecialchars($row["movie"]); ?></td>
                    <td><?php echo htmlspecialchars($row["screening"]); ?></td>
                    <td><?php echo (int)$row["tickets"]; ?></td>
                </tr>
            <?php } ?>
        </table>
 
    <?php } ?>
 
    <p><a href="logout.php">Logout</a></p>
</main>

<?php include "includes/footer.php"; ?>