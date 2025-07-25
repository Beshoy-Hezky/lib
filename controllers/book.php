<?php
require_once __DIR__ . '/../models/book_model.php';
$id = $_GET['id'] ?? 0;
$book = get_book($id);
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/book.php';
include __DIR__ . '/../views/footer.php';
