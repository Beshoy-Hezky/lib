<?php
require_once __DIR__ . '/../models/user_model.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (find_user_by_email($email)) {
        $message = 'User already exists';
    } else {
        if (create_user($email, $password)) {
            header('Location: index.php?page=login');
            exit;
        } else {
            $message = 'Registration failed';
        }
    }
}
include __DIR__ . '/../views/header.php';
include __DIR__ . '/../views/register.php';
include __DIR__ . '/../views/footer.php';
