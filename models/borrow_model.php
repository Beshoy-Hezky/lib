<?php
include 'models/db.php';

function is_book_borrowed($book_id) {
    $db = get_db();
    $stmt = $db->prepare('SELECT COUNT(*) FROM borrowings WHERE book_id = ? AND return_date IS NULL');
    $stmt->execute(array($book_id));
    return $stmt->fetchColumn() > 0;
}

function borrow_book($book_id, $user_id) {
    if (is_book_borrowed($book_id)) {
        return false;
    }
    $db = get_db();
    $stmt = $db->prepare('INSERT INTO borrowings (user_id, book_id) VALUES (?, ?)');
    return $stmt->execute(array($user_id, $book_id));
}

function return_book($borrow_id) {
    $db = get_db();
    $stmt = $db->prepare('UPDATE borrowings SET return_date = NOW() WHERE id = ?');
    return $stmt->execute(array($borrow_id));
}

function get_user_borrowings($user_id) {
    $db = get_db();
    $stmt = $db->prepare('SELECT br.id as borrow_id, b.* , br.borrow_date, br.return_date
                          FROM borrowings br JOIN books b ON br.book_id = b.id
                          WHERE br.user_id = ? AND br.return_date IS NULL');
    $stmt->execute(array($user_id));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_user_active_borrow($user_id, $book_id) {
    $db = get_db();
    $stmt = $db->prepare('SELECT id FROM borrowings WHERE user_id = ? AND book_id = ? AND return_date IS NULL');
    $stmt->execute(array($user_id, $book_id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_all_borrowings() {
    $db = get_db();
    $stmt = $db->query('SELECT br.id as borrow_id, b.title, u.email, br.borrow_date, br.return_date
                        FROM borrowings br
                        JOIN books b ON br.book_id = b.id
                        JOIN users u ON br.user_id = u.id
                        ORDER BY br.borrow_date DESC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
