<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$event_id = $_GET['id'] ?? null;

if (!$event_id) {
    die("Invalid event ID.");
}

// Check if user is already registered
$stmt = $conn->prepare("SELECT * FROM attendees WHERE event_id = ? AND user_id = ?");
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("You have already registered for this event.");
}

// Check if event is full
$stmt = $conn->prepare("SELECT COUNT(*) as total, max_capacity FROM events LEFT JOIN attendees ON events.id = attendees.event_id WHERE events.id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event_data = $stmt->get_result()->fetch_assoc();

if ($event_data['total'] >= $event_data['max_capacity']) {
    die("Registration is full for this event.");
}

// Register user for the event
$stmt = $conn->prepare("INSERT INTO attendees (event_id, user_id) VALUES (?, ?)");
$stmt->bind_param("ii", $event_id, $user_id);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}
?>
<a href="dashboard.php">Go back to Dashboard</a>
