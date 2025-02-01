<?php
include 'includes/auth.php';
include 'includes/db.php';

redirectIfNotLoggedIn();

// Get the event ID from the query string
if (!isset($_GET['id'])) {
    die("Event ID not provided.");
}

$eventId = $_GET['id'];

// Check if the logged-in user owns the event
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ? AND created_by = ?");
$stmt->execute([$eventId, $_SESSION['user_id']]);
$event = $stmt->fetch();

if (!$event) {
    die("You do not have permission to delete this event or the event does not exist.");
}

// Delete the event
try {
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    $stmt->execute([$eventId]);

    // Also delete associated attendees
    $stmt = $pdo->prepare("DELETE FROM attendees WHERE event_id = ?");
    $stmt->execute([$eventId]);

    header("Location: dashboard.php");
    exit;
} catch (PDOException $e) {
    die("Error deleting event: " . $e->getMessage());
}
?>