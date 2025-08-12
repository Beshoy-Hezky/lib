<?php
require_once __DIR__ . '/../models/borrow_model.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}
$borrow_id = $_GET['id'] ?? 0;
return_book($borrow_id);
header('Location: index.php?page=dashboard');
