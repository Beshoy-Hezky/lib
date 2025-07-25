<?php
require_once __DIR__ . '/../models/book_model.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}
$books = get_books();
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/dashboard.php';
include __DIR__ . '/../views/footer.php';
