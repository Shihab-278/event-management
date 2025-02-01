<?php
include 'includes/auth.php';
redirectIfNotLoggedIn(); // Ensure only logged-in users can access this page
?>
<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Profile Card -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Profile</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-user-circle fa-3x me-3"></i>
                        <div>
                            <p class="mb-0"><strong>Username:</strong> <?= htmlspecialchars($_SESSION['username']) ?></p>
                            <p class="mb-0"><strong>User ID:</strong> <?= htmlspecialchars($_SESSION['user_id']) ?></p>
                            <p class="mb-0"><strong>Role:</strong> <?= htmlspecialchars($_SESSION['role']) ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-end">
                        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>