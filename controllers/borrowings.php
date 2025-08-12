<?php
require_once __DIR__ . '/../models/borrow_model.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}
$records = get_all_borrowings();
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/borrowings.php';
include __DIR__ . '/../views/footer.php';
