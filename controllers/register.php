<?php
include 'models/user_model.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
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
include 'views/header.php';
include 'views/register.php';
include 'views/footer.php';
