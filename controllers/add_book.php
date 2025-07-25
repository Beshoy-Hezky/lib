<?php
require_once __DIR__ . '/../models/book_model.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $category = $_POST['category'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    if (add_book($title, $author, $category, $isbn)) {
        header('Location: index.php?page=dashboard');
        exit;
    } else {
        $message = 'Failed to add book';
    }
}
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/add_book.php';
include __DIR__ . '/../views/footer.php';
