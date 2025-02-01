<?php
include 'includes/auth.php';
include 'includes/db.php';

redirectIfNotLoggedIn();

// Get the event ID from the query string
if (!isset($_GET['id'])) {
    die("Event ID not provided.");
}

$eventId = $_GET['id'];

try {
    // Fetch the event and check if the user is an admin or the event owner
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$eventId]);
    $event = $stmt->fetch();

    if (!$event) {
        die("Event does not exist.");
    }

    if ($_SESSION['role'] !== 'admin' && $event['created_by'] !== $_SESSION['user_id']) {
        die("You do not have permission to delete this event.");
    }

    // Delete associated attendees first
    $stmt = $pdo->prepare("DELETE FROM attendees WHERE event_id = ?");
    $stmt->execute([$eventId]);

    // Now delete the event
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$eventId]);

    // Redirect to the dashboard after successful deletion
    header("Location: dashboard.php");
    exit;
} catch (PDOException $e) {
    die("Error deleting event: " . $e->getMessage());
}
?>

<!-- Edit and Delete Buttons (Only for Admins) -->
<?php if (isAdmin()): ?>
    <a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
    <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $event['id'] ?>)">Delete</button>
<?php else: ?>
    <!-- Register as Attendee Button (Only for Users) -->
    <?php
    // Check if the event is full
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM attendees WHERE event_id = ?");
    $stmt->execute([$event['id']]);
    $attendeeCount = $stmt->fetch()['count'];

    if ($attendeeCount < $event['capacity']): ?>
        <a href="register_attendee.php?id=<?= $event['id'] ?>" class="btn btn-success btn-sm">Register as Attendee</a>
    <?php else: ?>
        <span class="btn btn-secondary btn-sm disabled">Event Full</span>
    <?php endif; ?>
<?php endif; ?>