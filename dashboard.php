<?php
include 'includes/auth.php';
include 'includes/db.php';
redirectIfNotLoggedIn();
// Pagination setup
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; // Number of events per page
$offset = ($page - 1) * $limit;
// Sorting setup
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
// Filtering setup
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$whereClause = $filter ? "WHERE name LIKE '%$filter%'" : '';
try {
    // Fetch total events for pagination
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM events $whereClause");
    $stmt->execute();
    $totalEvents = $stmt->fetch()['total'];
    $totalPages = ceil($totalEvents / $limit);
    // Fetch paginated, sorted, and filtered events
    $stmt = $pdo->prepare("SELECT * FROM events $whereClause ORDER BY $sort $order LIMIT $limit OFFSET $offset");
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as an array
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">My Events</h2>
        <!-- Button to Create New Event -->
        <a href="create_event.php" class="btn btn-success">Create New Event</a>
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
                    <th scope="col">
                        <a href="?sort=id&order=<?= $sort === 'id' && $order === 'ASC' ? 'DESC' : 'ASC' ?>" class="text-decoration-none text-white">
                            ID
                        </a>
                    </th>
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
                        <tr>
                            <td><?= htmlspecialchars($event['id']) ?></td>
                            <td><?= htmlspecialchars($event['name']) ?></td>
                            <td><?= htmlspecialchars($event['date']) ?></td>
                            <td><?= htmlspecialchars($event['capacity']) ?></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="view_event.php?id=<?= $event['id'] ?>" class="btn btn-info btn-sm">View</a>
                                    <a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_event.php?id=<?= $event['id'] ?>" class="btn btn-danger btn-sm delete-event">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted fst-italic">No events found.</td>
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