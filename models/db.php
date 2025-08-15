<?php
// Database connection using PDO

function get_db() {
    $host = 'localhost';
    $dbname = 'electronic_library';
    $user = 'ts_user';
    $pass = 'pa55word';
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
    return $db;
}
