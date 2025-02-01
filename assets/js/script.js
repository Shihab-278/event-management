// assets/js/script.js

document.addEventListener('DOMContentLoaded', function () {
    // Confirm deletion of events
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const confirmDelete = confirm('Are you sure you want to delete this event?');
            if (!confirmDelete) {
                e.preventDefault(); // Prevent the default action if the user cancels
            }
        });
    });

    // Form validation for attendee registration
    const attendeeForms = document.querySelectorAll('form[action="register_attendee.php"]');
    attendeeForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const name = form.querySelector('input[name="name"]').value.trim();
            const email = form.querySelector('input[name="email"]').value.trim();

            if (!name || !email) {
                alert('Please fill out all fields.');
                e.preventDefault(); // Prevent form submission
            } else if (!validateEmail(email)) {
                alert('Please enter a valid email address.');
                e.preventDefault(); // Prevent form submission
            }
        });
    });

    // Email validation function
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});