<?php
include 'models/book_model.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php?page=login');
    exit;
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
    if (add_book($title, $author, $category, $isbn)) {
        header('Location: index.php?page=dashboard');
        exit;
    } else {
        $message = 'Failed to add book';
    }
}
include 'views/header.php';
include 'views/add_book.php';
include 'views/footer.php';
