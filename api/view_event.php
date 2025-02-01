<?php
include 'includes/auth.php';
include 'includes/db.php';
include 'includes/functions.php';

redirectIfNotLoggedIn();

$id = $_GET['id'];
$userId = $_SESSION['user_id']; // Assuming the user ID is stored in the session

// Fetch event details
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();

if (!$event) {
    die("Event not found.");
}

// Fetch all attendees for the event
$stmt = $pdo->prepare("SELECT name, email FROM attendees WHERE event_id = ?");
$stmt->execute([$id]);
$attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="attendees.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name', 'Email']);

    foreach ($attendees as $attendee) {
        fputcsv($output, $attendee);
    }

    fclose($output);
    exit;
}

// Check if the current user is already registered for the event
$stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM attendees WHERE event_id = ? AND user_id = ?");
$stmt->execute([$id, $userId]);
$isRegistered = $stmt->fetch()['count'] > 0;

// Check if the event is full
$stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM attendees WHERE event_id = ?");
$stmt->execute([$id]);
$attendeeCount = $stmt->fetch()['count'];
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Event Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><?= htmlspecialchars($event['name']) ?></h4>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> <?= htmlspecialchars($event['description']) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($event['location']) ?></p>
                    <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                    <p><strong>Capacity:</strong> <?= htmlspecialchars($event['capacity']) ?></p>

                    <!-- Attendee Registration Button -->
                    <?php if (!$isRegistered && $attendeeCount < $event['capacity'] && !isAdmin()): ?>
                        <a href="register_attendee.php?id=<?= $event['id'] ?>" class="btn btn-success w-100">Register as Attendee</a>
                    <?php elseif ($isRegistered): ?>
                        <button class="btn btn-success w-100" disabled>You are already registered for this event!</button>
                    <?php elseif ($attendeeCount >= $event['capacity']): ?>
                        <p class="text-danger fw-bold">This event is full!</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Attendees Table Card -->
            <?php if (isAdmin()): ?>
                <div class="card shadow">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Attendees</h5>
                        <!-- Download Attendees Report Button -->
                        <a href="view_event.php?id=<?= $event['id'] ?>&export=csv" class="btn btn-light btn-sm">Download Report</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($attendees)): ?>
                                    <?php foreach ($attendees as $attendee): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($attendee['name']) ?></td>
                                            <td><?= htmlspecialchars($attendee['email']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center">No attendees registered yet.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Back to Dashboard Button -->
            <div class="card-footer text-center">
                <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>