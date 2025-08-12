<?php
require_once __DIR__ . '/../models/book_model.php';
require_once __DIR__ . '/../models/borrow_model.php';
$id = $_GET['id'] ?? 0;
$book = get_book($id);
$is_borrowed = false;
$user_borrow_id = null;
if ($book) {
    $is_borrowed = is_book_borrowed($id);
    if (isset($_SESSION['user_id'])) {
        $row = get_user_active_borrow($_SESSION['user_id'], $id);
        if ($row) {
            $user_borrow_id = $row['id'];
        }
    }
}
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/book.php';
include __DIR__ . '/../views/footer.php';
