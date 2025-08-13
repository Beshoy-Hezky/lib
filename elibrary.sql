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
('admin@example.com', '$2y$12$LByreBIhsQcIYUEn45jq.u7yY8k646wOQ7BqFuXq/C2tmXtp1beqC', 'admin'), -- password is "password" 
('user@example.com', '$2y$12$LByreBIhsQcIYUEn45jq.u7yY8k646wOQ7BqFuXq/C2tmXtp1beqC', 'user');  -- password is "password" 

INSERT INTO books (title, author, category, isbn) VALUES
('Pride and Prejudice','Jane Austen','Romance','9781503290563'),
('Moby-Dick','Herman Melville','Adventure','9781503280786'),
('War and Peace','Leo Tolstoy','Historical Fiction','9780199232765'),
('The Catcher in the Rye','J.D. Salinger','Fiction','9780316769488'),
('The Hobbit','J.R.R. Tolkien','Fantasy','9780547928227'),
('Brave New World','Aldous Huxley','Dystopian','9780060850524'),
('Crime and Punishment','Fyodor Dostoevsky','Classic','9780486415871'),
('The Lord of the Rings','J.R.R. Tolkien','Fantasy','9780544003415'),
('Jane Eyre','Charlotte Brontë','Gothic Fiction','9780141441146'),
('The Alchemist','Paulo Coelho','Adventure','9780061122415');

INSERT INTO borrowings (user_id, book_id, borrow_date) VALUES
(1, 1, '2025-08-01 10:00:00'),
(2, 3, '2025-08-05 14:30:00');

-- Create a user named ts_user
GRANT SELECT, INSERT, UPDATE, DELETE
ON *
TO ts_user@localhost
IDENTIFIED BY 'pa55word';
