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
    die("You do not have permission to edit this event or the event does not exist.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $capacity = $_POST['capacity'];

    try {
        $stmt = $pdo->prepare("UPDATE events SET name = ?, description = ?, date = ?, capacity = ? WHERE id = ?");
        $stmt->execute([$name, $description, $date, $capacity, $eventId]);

        header("Location: view_event.php?id=$eventId");
        exit;
    } catch (PDOException $e) {
        die("Error updating event: " . $e->getMessage());
    }
}
?>

<?php include 'includes/header.php'; ?>
    <div class="container mt-5">
        <h2>Edit Event</h2>
        <form method="POST" id="edit-event-form">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($event['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($event['date']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="number" class="form-control" id="capacity" name="capacity" value="<?= htmlspecialchars($event['capacity']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Event</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript for Edit Event Form Validation
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('edit-event-form');
            form.addEventListener('submit', function (e) {
                const name = form.querySelector('input[name="name"]').value.trim();
                const description = form.querySelector('textarea[name="description"]').value.trim();
                const date = form.querySelector('input[name="date"]').value.trim();
                const capacity = form.querySelector('input[name="capacity"]').value.trim();

                if (!name || !date || !capacity) {
                    alert('Please fill out all required fields.');
                    e.preventDefault(); // Prevent form submission
                } else if (isNaN(capacity) || parseInt(capacity) <= 0) {
                    alert('Capacity must be a positive number.');
                    e.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
<?php include 'includes/footer.php'; ?>