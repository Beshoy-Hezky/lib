<?php
require_once __DIR__ . '/db.php';

function find_user_by_email($email) {
    $db = get_db();
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function create_user($email, $password, $role = 'user') {
    $db = get_db();
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $db->prepare('INSERT INTO users (email, password, role) VALUES (?, ?, ?)');
    return $stmt->execute([$email, $hash, $role]);
}
