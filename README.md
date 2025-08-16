# MyExpensesApp

A simple **PHP & MySQL** web application to manage personal expenses.  
Users can add, edit, delete, and view expenses and categories.

---

## Features

- User authentication (login & registration)
- Add, edit, delete, and view expenses
- Add, edit, delete, and view categories
- Dashboard showing total expenses
- Responsive design using Bootstrap

---

## Technology Stack

- PHP 8+
- MySQL / MariaDB
- HTML, CSS, Bootstrap 5
- JavaScript (for Bootstrap components)
- XAMPP / Local server for development

---

## Installation / Setup

1. Clone the repository:  
   ```bash
   git clone https://github.com/ayaayman1234/ExpensesTracker.git
````

2. Open `XAMPP` and start `Apache` & `MySQL`.

3. Import the database:

   * Open `phpMyAdmin` and create a new database, e.g., `expenses_db`.
   * Import the provided SQL file (if any).

4. Update database config:

   ```php
   // includes/config.php
   $host = 'localhost';
   $dbname = 'expenses_db';
   $username = 'root';
   $password = '';
   ```

5. Open the project in your browser:

   ```
   http://localhost/assests/dashboard.php
   ```

---

## Usage

* Register a new account or login with existing credentials.
* Add, edit, and delete expenses via the dashboard.
* Manage categories from the Categories section.
* View total expenses on the dashboard.

---

## License

This project is open-source and free to use.




