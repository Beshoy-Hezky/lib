# PHP E-Library System

This is a simple E-Library web application demonstrating a basic MVC structure using plain PHP and PDO.

## Requirements
- PHP 8
- MySQL

## Setup
1. Import `elibrary.sql` into your MySQL server to create the database and sample data.
2. Update the database credentials in `models/db.php` if necessary.
3. Place the project in your web server root and access `index.php` via a browser.
4. Login with `admin@example.com` / `password` for admin access or `user@example.com` / `password` for regular user.

## Features
- User registration and login
- Admin dashboard with CRUD operations for books
- Book listing with search and ordering
- Simple styling with CSS
- Borrowing system with user returns and admin records
