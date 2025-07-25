<?php
require_once __DIR__ . '/../models/book_model.php';
$books = get_books();
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/home.php';
include __DIR__ . '/../views/footer.php';
