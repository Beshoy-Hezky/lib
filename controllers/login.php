<?php
include 'models/user_model.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
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
include 'views/header.php';
include 'views/login.php';
include 'views/footer.php';
