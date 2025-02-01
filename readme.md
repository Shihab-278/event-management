# Event Management System

## Project Overview
The Event Management System is a web application designed to help users manage events efficiently. It includes features for user authentication, event creation, updating, deletion, viewing, attendee registration, and admin reports in CSV format. The system also provides a dashboard with pagination, sorting, and filtering capabilities.

## Features
- User Authentication (Login/Register)
- Event Management (Create, Update, Delete, View)
- Attendee Registration
- Event Dashboard with Pagination, Sorting, and Filtering
- Admin Reports (Attendee,Events) in CSV Format

## Setup Instructions
1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/event-management-system.git
   cd event-management-system
   ```
2. Create a MySQL database named `event_management`.
3. Import the SQL schema provided in the project.
4. Configure `includes/db.php` with your database credentials.
5. Run the project on a local server (e.g., XAMPP, WAMP).
6. Access the application via `http://localhost/event-management/`.


## Login Credentials for Testing
- Admin Account
    Username: shihab
    Password: 123456
- User Account
    Username: user
    Password: user123
## Technologies Used
- PHP (Backend)
- MySQL (Database)
- Bootstrap (Frontend)
