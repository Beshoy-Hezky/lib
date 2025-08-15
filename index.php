<?php
session_start();
require 'models/db.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'login':
        require 'controllers/login.php';
        break;
    case 'register':
        require 'controllers/register.php';
        break;
    case 'books':
        require 'controllers/books.php';
        break;
    case 'book':
        require 'controllers/book.php';
        break;
    case 'add_book':
        require 'controllers/add_book.php';
        break;
    case 'edit_book':
        require 'controllers/edit_book.php';
        break;
    case 'delete_book':
        require 'controllers/delete_book.php';
        break;
    case 'borrow_book':
        require 'controllers/borrow_book.php';
        break;
    case 'return_book':
        require 'controllers/return_book.php';
        break;
    case 'borrowings':
        require 'controllers/borrowings.php';
        break;
    case 'logout':
        require 'controllers/logout.php';
        break;
    case 'dashboard':
        require 'controllers/dashboard.php';
        break;
    default:
        require 'controllers/home.php';
}
