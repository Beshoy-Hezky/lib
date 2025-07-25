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
    <a href="index.php?page=books">Books</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="index.php?page=dashboard">Dashboard</a>
        <a href="index.php?page=logout">Logout</a>
    <?php else: ?>
        <a href="index.php?page=login">Login</a>
        <a href="index.php?page=register">Register</a>
    <?php endif; ?>
</nav>
<div class="container">
