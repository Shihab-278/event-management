<?php
include 'includes/auth.php';
include 'includes/db.php';
redirectIfNotLoggedIn();

// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Number of events per page
$offset = ($page - 1) * $limit;

// Sorting setup
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'created_at'; // Default sort by creation date
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC'; // Default order: descending (latest first)

// Filtering setup
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$whereClause = $filter ? "WHERE name LIKE :filter" : '';

try {
    // Fetch total events for pagination
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM events $whereClause");
    if ($filter) {
        $stmt->bindValue(':filter', "%$filter%", PDO::PARAM_STR);
    }
    $stmt->execute();
    $totalEvents = $stmt->fetch()['total'];
    $totalPages = ceil($totalEvents / $limit);

    // Fetch paginated, sorted, and filtered events
    $stmt = $pdo->prepare("SELECT * FROM events $whereClause ORDER BY $sort $order LIMIT :limit OFFSET :offset");
    if ($filter) {
        $stmt->bindValue(':filter', "%$filter%", PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12 col-md-6">
            <h2 class="text-primary">My Events</h2>
        </div>
        <div class="col-12 col-md-6 text-md-end text-center">
            <!-- Button to Create New Event (Only for Admins) -->
            <?php if (isAdmin()): ?>
                <a href="create_event.php" class="btn btn-success">Create New Event</a>
                <a href="download_report.php" class="btn btn-primary">Generate Events Report</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Filter Form -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="filter" class="form-control" placeholder="Search by event name" value="<?= htmlspecialchars($filter) ?>">
            <button type="submit" class="btn btn-outline-primary">Filter</button>
        </div>
    </form>
    <!-- Events Table -->
    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <!-- Show ID column only for admins -->
                    <?php if (isAdmin()): ?>
                        <th scope="col">
                            <a href="?sort=id&order=<?= $sort === 'id' && $order === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-decoration-none text-white">
                                ID
                            </a>
                        </th>
                    <?php endif; ?>
                    <th scope="col">
                        <a href="?sort=name&order=<?= $sort === 'name' && $order === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-decoration-none text-white">
                            Name
                        </a>
                    </th>
                    <th scope="col">
                        <a href="?sort=date&order=<?= $sort === 'date' && $order === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-decoration-none text-white">
                            Date
                        </a>
                    </th>
                    <th scope="col">Capacity</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <?php
                        // Check if the logged-in user is already registered for this event
                        $userId = $_SESSION['user_id'];
                        $stmt = $pdo->prepare("SELECT * FROM attendees WHERE event_id = ? AND user_id = ?");
                        $stmt->execute([$event['id'], $userId]);
                        $isAttending = $stmt->fetch();
                        ?>
                        <tr>
                            <!-- Show ID column only for admins -->
                            <?php if (isAdmin()): ?>
                                <td><?= htmlspecialchars($event['id']) ?></td>
                            <?php endif; ?>
                            <td><?= htmlspecialchars($event['name']) ?></td>
                            <td><?= htmlspecialchars($event['date']) ?></td>
                            <td><?= htmlspecialchars($event['capacity']) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <!-- View Event Button -->
                                    <a href="view_event.php?id=<?= $event['id'] ?>" class="btn btn-info btn-sm">View</a>
                                    <!-- Edit and Delete Buttons (Only for Admins) -->
                                    <?php if (isAdmin()): ?>
                                        <a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete_event.php?id=<?= $event['id'] ?>" class="btn btn-danger btn-sm delete-event">Delete</a>
                                    <?php else: ?>
                                        <!-- Attendance Status -->
                                        <?php if ($isAttending): ?>
                                            <span class="btn btn-success btn-sm disabled">✔ Attending</span>
                                        <?php else: ?>
                                            <!-- Register as Attendee Button -->
                                            <?php
                                            // Check if the event is full
                                            $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM attendees WHERE event_id = ?");
                                            $stmt->execute([$event['id']]);
                                            $attendeeCount = $stmt->fetch()['count'];
                                            if ($attendeeCount < $event['capacity']): ?>
                                                <a href="register_attendee.php?id=<?= $event['id'] ?>" class="btn btn-success btn-sm">Register as Attendee</a>
                                            <?php else: ?>
                                                <span class="btn btn-secondary btn-sm disabled">Event Full</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= isAdmin() ? 5 : 4 ?>" class="text-center text-muted fst-italic">No events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&sort=<?= $sort ?>&order=<?= $order ?>&filter=<?= $filter ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>
<!-- JavaScript for Delete Confirmation -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-event');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent the default link behavior
                const confirmDelete = confirm('Are you sure you want to delete this event?');
                if (confirmDelete) {
                    window.location.href = button.getAttribute('href'); // Redirect to delete URL
                }
            });
        });
    });
</script>
<?php include 'includes/footer.php'; ?>