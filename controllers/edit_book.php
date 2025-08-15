<?php
include 'models/book_model.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php?page=login');
    exit;
}
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$book = get_book($id);
$message = '';
if (!$book) {
    header('Location: index.php?page=dashboard');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $author = isset($_POST['author']) ? $_POST['author'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $isbn = isset($_POST['isbn']) ? $_POST['isbn'] : '';
    if (update_book($id, $title, $author, $category, $isbn)) {
        header('Location: index.php?page=dashboard');
        exit;
    } else {
        $message = 'Failed to update book';
    }
}
include 'views/header.php';
include 'views/edit_book.php';
include 'views/footer.php';
