<?php
session_start();
require_once __DIR__ . '/models/db.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'login':
        require __DIR__ . '/controllers/login.php';
        break;
    case 'register':
        require __DIR__ . '/controllers/register.php';
        break;
    case 'books':
        require __DIR__ . '/controllers/books.php';
        break;
    case 'book':
        require __DIR__ . '/controllers/book.php';
        break;
    case 'add_book':
        require __DIR__ . '/controllers/add_book.php';
        break;
    case 'edit_book':
        require __DIR__ . '/controllers/edit_book.php';
        break;
    case 'delete_book':
        require __DIR__ . '/controllers/delete_book.php';
        break;
    case 'logout':
        require __DIR__ . '/controllers/logout.php';
        break;
    case 'dashboard':
        require __DIR__ . '/controllers/dashboard.php';
        break;
    default:
        require __DIR__ . '/controllers/home.php';
}
