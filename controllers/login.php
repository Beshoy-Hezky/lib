<?php
require_once __DIR__ . '/../models/user_model.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $user = find_user_by_email($email);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header('Location: index.php?page=dashboard');
        exit;
    } else {
        $message = 'Invalid credentials';
    }
}
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/login.php';
include __DIR__ . '/../views/footer.php';
