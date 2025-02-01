<?php include 'includes/header.php'; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Event Management</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Events</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container mt-5">
    <h1>Welcome to Event Management System</h1>
    <p>Manage your events efficiently with our system.</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <h2>Upcoming Events</h2>
            <p>Check out the upcoming events and plan accordingly.</p>
            <a class="btn btn-primary" href="#">View Events</a>
        </div>
        <div class="col-md-4">
            <h2>Create Event</h2>
            <p>Create new events and manage existing ones with ease.</p>
            <a class="btn btn-primary" href="#">Create Event</a>
        </div>
        <div class="col-md-4">
            <h2>Contact Us</h2>
            <p>Have any questions? Get in touch with us.</p>
            <a class="btn btn-primary" href="#">Contact</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>