<?php
include 'includes/auth.php';
include 'includes/db.php';
redirectIfNotLoggedIn();
$eventId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$eventId]);
$event = $stmt->fetch();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    // Check if the event is full
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM attendees WHERE event_id = ?");
    $stmt->execute([$eventId]);
    $count = $stmt->fetch()['count'];
    if ($count >= $event['capacity']) {
        echo "<p class='text-danger text-center'>Event is full! Cannot register more attendees.</p>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO attendees (event_id, name, email) VALUES (?, ?, ?)");
        $stmt->execute([$eventId, $name, $email]);
        header("Location: view_event.php?id=$eventId");
        exit;
    }
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Registration Card -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Register for <?= htmlspecialchars($event['name']) ?></h4>
                </div>
                <div class="card-body">
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
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and Custom Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Enable Bootstrap validation styles
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('attendee-form');
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault(); // Prevent form submission
                e.stopPropagation(); // Stop propagation
            }
            form.classList.add('was-validated'); // Trigger Bootstrap validation styles
        });

        // Email validation function
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(email).toLowerCase());
        }
    });
</script>
<?php include 'includes/footer.php'; ?>