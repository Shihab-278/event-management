<?php
include 'includes/auth.php';
include 'includes/db.php';
include 'includes/functions.php';

redirectIfNotLoggedIn();

// Only admins can access this page
if (!isAdmin()) {
    die("Access denied. Only admins can generate reports.");
}

try {
    // Fetch all events from the database
    $stmt = $pdo->prepare("SELECT * FROM events ORDER BY date ASC");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debugging: Check if events are fetched
    if (empty($events)) {
        die("No events found to generate a report.");
    }

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="events_report.csv"');

    // Open output stream
    $output = fopen('php://output', 'w');

    // Add CSV headers
    fputcsv($output, ['ID', 'Name', 'Date', 'Capacity', 'Description']);

    // Add event data to the CSV
    foreach ($events as $event) {
        fputcsv($output, [
            $event['id'] ?? 'N/A', // Use null coalescing operator to avoid undefined key errors
            $event['name'] ?? 'N/A',
            $event['date'] ?? 'N/A',
            $event['capacity'] ?? 'N/A',
            $event['description'] ?? 'N/A'
        ]);
    }

    // Close the output stream
    fclose($output);
    exit;
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>