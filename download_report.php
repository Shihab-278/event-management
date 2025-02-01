<?php
include 'includes/auth.php';
include 'includes/db.php';
include 'includes/functions.php'; // Add this line

redirectIfNotLoggedIn();

if (!isAdmin()) {
    die("Access denied.");
}

$eventId = $_GET['id'];
$stmt = $pdo->prepare("SELECT name, email FROM attendees WHERE event_id = ?");
$stmt->execute([$eventId]);
$attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);

generateCsv($attendees, "attendees_report.csv"); // Now this function will work
?>