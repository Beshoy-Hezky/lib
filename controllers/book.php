<?php
include 'models/book_model.php';
include 'models/borrow_model.php';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
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
include 'views/header.php';
include 'views/book.php';
include 'views/footer.php';
