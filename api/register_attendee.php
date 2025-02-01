<?php
include 'includes/auth.php';
include 'includes/db.php';

redirectIfNotLoggedIn();

$eventId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$eventId]);
$event = $stmt->fetch();

if (!$event) {
    die("Event not found.");
}

$userId = $_SESSION['user_id']; // Get the logged-in user's ID

// Check if the user is already registered for this event
$stmt = $pdo->prepare("SELECT * FROM attendees WHERE event_id = ? AND user_id = ?");
$stmt->execute([$eventId, $userId]);
$alreadyRegistered = $stmt->fetch();

if ($alreadyRegistered) {
    $registrationError = "You are already registered for this event.";
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Check if the event is full
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM attendees WHERE event_id = ?");
        $stmt->execute([$eventId]);
        $count = $stmt->fetch()['count'];

        if ($count >= $event['capacity']) {
            $registrationError = "Event is full! Cannot register more attendees.";
        } else {
            // Register the user
            $stmt = $pdo->prepare("INSERT INTO attendees (event_id, user_id, name, email) VALUES (?, ?, ?, ?)");
            $stmt->execute([$eventId, $userId, $name, $email]);

            header("Location: view_event.php?id=$eventId");
            exit;
        }
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-6 col-sm-10">
            <!-- Registration Card -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-center">Register for <?= htmlspecialchars($event['name']) ?></h4>
                </div>
                <div class="card-body">
                    <?php if (isset($registrationError)): ?>
                        <div class="alert alert-danger text-center"><?= $registrationError ?></div>
                    <?php endif; ?>
                    <form method="POST" id="attendee-form" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                            <div class="invalid-feedback">Please enter your name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" <?= isset($registrationError) ? 'disabled' : '' ?>>Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS and Custom Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('attendee-form');
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>
<?php include 'includes/footer.php'; ?>