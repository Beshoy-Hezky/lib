<?php
include 'models/borrow_model.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}
$borrow_id = isset($_GET['id']) ? $_GET['id'] : 0;
return_book($borrow_id);
header('Location: index.php?page=dashboard');
