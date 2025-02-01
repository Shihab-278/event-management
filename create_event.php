<?php
include 'includes/auth.php';
include 'includes/db.php';
redirectIfNotLoggedIn();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $capacity = $_POST['capacity'];
    $stmt = $pdo->prepare("INSERT INTO events (name, description, date, capacity, created_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $description, $date, $capacity, $_SESSION['user_id']]);
    header("Location: dashboard.php");
    exit;
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create Event</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter event name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Provide a detailed description of the event"></textarea>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Max attendees" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Create Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>