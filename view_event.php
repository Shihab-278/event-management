<?php
include 'includes/auth.php';
include 'includes/db.php';
redirectIfNotLoggedIn();
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$id]);
$event = $stmt->fetch();
$stmt = $pdo->prepare("SELECT * FROM attendees WHERE event_id = ?");
$stmt->execute([$id]);
$attendees = $stmt->fetchAll();
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
                    <p><strong>Date:</strong> <?= htmlspecialchars($event['date']) ?></p>
                    <p><strong>Capacity:</strong> <?= htmlspecialchars($event['capacity']) ?></p>

                    <!-- Attendee Registration Button -->
                    <?php
                    // Check if the event is full
                    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM attendees WHERE event_id = ?");
                    $stmt->execute([$id]);
                    $attendeeCount = $stmt->fetch()['count'];
                    if ($attendeeCount < $event['capacity']): ?>
                        <a href="register_attendee.php?id=<?= $event['id'] ?>" class="btn btn-success w-100">Register as Attendee</a>
                    <?php else: ?>
                        <p class="text-danger fw-bold">This event is full!</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Attendees Table Card -->
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Attendees</h5>
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
                            <?php foreach ($attendees as $attendee): ?>
                                <tr>
                                    <td><?= htmlspecialchars($attendee['name']) ?></td>
                                    <td><?= htmlspecialchars($attendee['email']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>