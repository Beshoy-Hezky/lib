<?php
require_once __DIR__ . '/../models/book_model.php';
$search = $_GET['search'] ?? '';
$order = $_GET['order'] ?? 'title';
$books = get_books($search, $order, true);
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/books.php';
include __DIR__ . '/../views/footer.php';
