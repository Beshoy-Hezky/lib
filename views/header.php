<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>E-Library</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav>
    <a href="index.php">Home</a>
    <a href="index.php?page=books">Available Books</a>
    <?php if (isset($_SESSION['user_id'])) { ?>
        <?php if ($_SESSION['role'] == 'admin') { ?>
        <a href="index.php?page=dashboard">All Books</a>
        <?php } else { ?>
        <a href="index.php?page=dashboard">Borrowed Books</a>
        <?php } ?>
        <?php if ($_SESSION['role'] == 'admin') { ?>
            <a href="index.php?page=borrowings">Borrowings</a>
        <?php } ?>
        <a href="index.php?page=logout">Logout</a>
    <?php } else { ?>
        <a href="index.php?page=login">Login</a>
        <a href="index.php?page=register">Register</a>
    <?php } ?>
</nav>
<div class="container">
