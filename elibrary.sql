-- Database schema for E-Library
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

-- No initial borrowings
