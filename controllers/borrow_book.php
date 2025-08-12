<?php
require_once __DIR__ . '/../models/borrow_model.php';
require_once __DIR__ . '/../models/book_model.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}
$book_id = $_GET['id'] ?? 0;
$book = get_book($book_id);
if (!$book) {
    header('Location: index.php?page=books');
    exit;
}
borrow_book($book_id, $_SESSION['user_id']);
header('Location: index.php?page=dashboard');
