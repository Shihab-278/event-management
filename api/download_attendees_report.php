<?php
include 'includes/auth.php';
include 'includes/db.php';
include 'includes/functions.php';

redirectIfNotLoggedIn();

// Only admins can access this page
if (!isAdmin()) {
    die("Access denied. Only admins can download attendee reports.");
}

// Get the event ID from the query string
if (!isset($_GET['id'])) {
    die("Event ID not provided.");
}

$eventId = $_GET['id'];

try {
    // Fetch event details
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$eventId]);
    $event = $stmt->fetch();

    if (!$event) {
        die("Event not found.");
    }

    // Fetch attendees for the event
    $stmt = $pdo->prepare("SELECT * FROM attendees WHERE event_id = ?");
    $stmt->execute([$eventId]);
    $attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($attendees)) {
        die("No attendees found for this event.");
    }

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="attendees_report_' . str_replace(' ', '_', $event['name']) . '.csv"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Add CSV headers
    fputcsv($output, ['ID', 'Name', 'Email']);

    // Add attendee data to the CSV
    foreach ($attendees as $attendee) {
        fputcsv($output, [
            $attendee['id'],
            $attendee['name'],
            $attendee['email']
        ]);
    }

    // Close the output stream
    fclose($output);
    exit;
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>