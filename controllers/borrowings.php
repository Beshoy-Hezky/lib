<?php
include 'models/borrow_model.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php?page=login');
    exit;
}
$records = get_all_borrowings();
include 'views/header.php';
include 'views/borrowings.php';
include 'views/footer.php';
