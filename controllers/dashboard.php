<?php
require_once __DIR__ . '/../models/book_model.php';
require_once __DIR__ . '/../models/borrow_model.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}
if ($_SESSION['role'] === 'admin') {
    $books = get_books();
    $borrowings = [];
} else {
    $books = [];
    $borrowings = get_user_borrowings($_SESSION['user_id']);
}
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/dashboard.php';
include __DIR__ . '/../views/footer.php';
