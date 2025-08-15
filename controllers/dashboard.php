<?php
include 'models/book_model.php';
include 'models/borrow_model.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}
if ($_SESSION['role'] == 'admin') {
    $books = get_books();
    $borrowings = array();
} else {
    $books = array();
    $borrowings = get_user_borrowings($_SESSION['user_id']);
}
include 'views/header.php';
include 'views/dashboard.php';
include 'views/footer.php';
