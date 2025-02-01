<?php
include 'includes/auth.php';
include 'includes/db.php';

redirectIfNotLoggedIn();

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    die("You do not have permission to edit this event.");
}

// Get the event ID from the query string
if (!isset($_GET['id'])) {
    die("Event ID not provided.");
}

$eventId = $_GET['id'];

// Fetch the event details
$stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
$stmt->execute([$eventId]);
$event = $stmt->fetch();

if (!$event) {
    die("Event does not exist.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    // Update the event in the database
    $stmt = $pdo->prepare("UPDATE events SET name = ?, date = ?, location = ?, capacity = ? WHERE id = ?");
    $stmt->execute([$name, $date, $location, $capacity, $eventId]);

    // Redirect to the dashboard after successful update
    header("Location: dashboard.php");
    exit;
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Event</h2>
                </div>
                <div class="card-body">
                    <form id="edit-event-form" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>
                            <div class="invalid-feedback">Please enter the event name.</div>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($event['date']) ?>" required>
                            <div class="invalid-feedback">Please enter the event date.</div>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($event['location']) ?>" required>
                            <div class="invalid-feedback">Please enter the event location.</div>
                        </div>
                        <div class="mb-3">
                            <label for="capacity" class="form-label">Capacity</label>
                            <input type="number" class="form-control" id="capacity" name="capacity" value="<?= htmlspecialchars($event['capacity']) ?>" placeholder="Max attendees" required>
                            <div class="invalid-feedback">Please enter a positive number for capacity.</div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Enable Bootstrap validation styles
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('edit-event-form');
        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                e.preventDefault(); // Prevent form submission
                e.stopPropagation(); // Stop propagation
            }
            form.classList.add('was-validated'); // Trigger Bootstrap validation styles
        });
    });
</script>
<?php include 'includes/footer.php'; ?>