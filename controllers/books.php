<?php
include 'models/book_model.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'title';
$books = get_books($search, $order, true);
include 'views/header.php';
include 'views/books.php';
include 'views/footer.php';
