<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="bg-primary text-white py-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Welcome to Event Management System</h1>
        <p class="lead">Effortlessly manage, organize, and attend events with our intuitive platform.</p>
        <div class="mt-4">
            <a href="dashboard.php" class="btn btn-light btn-lg me-3">Get Started</a>
            <a href="contact.php" class="btn btn-outline-light btn-lg">Contact Us</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose Us?</h2>
        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Upcoming Events</h4>
                        <p class="card-text">Stay updated with upcoming events and plan your schedule effortlessly.</p>
                        <a href="dashboard.php" class="btn btn-primary">View Events</a>
                    </div>
                </div>
            </div>
            <!-- Feature 2 -->
             
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Create Event</h4>
                        <p class="card-text">Create new events and manage them with ease using our intuitive tools.</p>
                        <a href="#" class="btn btn-primary">Create Event</a>
                    </div>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Contact Us</h4>
                        <p class="card-text">Have questions or need support? Get in touch with our team today.</p>
                        <a href="contact.php" class="btn btn-primary">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="bg-light py-5">
    <div class="container">
        <h2 class="text-center mb-5">What Our Users Say</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- Testimonial 1 -->
                        <div class="carousel-item active">
                            <div class="card shadow text-center p-4">
                                <p class="card-text fst-italic">"This platform has made event management so much easier! Highly recommend it."</p>
                                <p class="fw-bold mb-0">- Jane Doe</p>
                            </div>
                        </div>
                        <!-- Testimonial 2 -->
                        <div class="carousel-item">
                            <div class="card shadow text-center p-4">
                                <p class="card-text fst-italic">"I love how intuitive and user-friendly this system is. Great job!"</p>
                                <p class="fw-bold mb-0">- John Smith</p>
                            </div>
                        </div>
                        <!-- Testimonial 3 -->
                        <div class="carousel-item">
                            <div class="card shadow text-center p-4">
                                <p class="card-text fst-italic">"The best tool for managing events. Saves me so much time!"</p>
                                <p class="fw-bold mb-0">- Emily Johnson</p>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!isset($_SESSION['user_id'])): ?>
<!-- Call to Action Section -->
<section class="bg-primary text-white py-5">
  <div class="container text-center">
    <h2 class="fw-bold">Ready to Get Started?</h2>
    <p class="lead">Join thousands of users who trust us to manage their events seamlessly.</p>
    <div class="mt-4">
      <a href="register.php" class="btn btn-light btn-lg me-3">Sign Up Now</a>
      <a href="login.php" class="btn btn-outline-light btn-lg">Login</a>
    </div>
  </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>