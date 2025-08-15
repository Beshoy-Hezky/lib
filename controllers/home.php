<?php
include 'models/book_model.php';
$books = get_books('', 'title', true);
include 'views/header.php';
include 'views/home.php';
include 'views/footer.php';
