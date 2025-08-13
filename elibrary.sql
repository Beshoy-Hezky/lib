DROP DATABASE IF EXISTS electronic_library;
CREATE DATABASE electronic_library;
USE electronic_library;

-- Database schema 
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user'
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    isbn VARCHAR(20)
);

CREATE TABLE borrowings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id INT NOT NULL,
    borrow_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    return_date DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

-- Sample data
INSERT INTO users (email, password, role) VALUES
('admin@example.com', '$2y$12$LByreBIhsQcIYUEn45jq.u7yY8k646wOQ7BqFuXq/C2tmXtp1beqC', 'admin'),
('user@example.com', '$2y$12$LByreBIhsQcIYUEn45jq.u7yY8k646wOQ7BqFuXq/C2tmXtp1beqC', 'user');

INSERT INTO books (title, author, category, isbn) VALUES
('The Great Gatsby','F. Scott Fitzgerald','Fiction','9780743273565'),
('1984','George Orwell','Dystopian','9780451524935'),
('To Kill a Mockingbird','Harper Lee','Fiction','9780061120084');

INSERT INTO borrowings (user_id, book_id, borrow_date) VALUES
(1, 1, '2025-08-01 10:00:00'),
(2, 3, '2025-08-05 14:30:00');

-- Create a user named ts_user
GRANT SELECT, INSERT, UPDATE, DELETE
ON *
TO ts_user@localhost
IDENTIFIED BY 'pa55word';
