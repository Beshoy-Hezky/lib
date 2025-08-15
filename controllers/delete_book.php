<?php
include 'models/book_model.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php?page=login');
    exit;
}
$id = isset($_GET['id']) ? $_GET['id'] : 0;
delete_book($id);
header('Location: index.php?page=dashboard');
