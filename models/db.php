<?php
// Database connection using PDO

function get_db() {
    static $db = null;
    if ($db === null) {
        $host = 'localhost';
        $dbname = 'electronic_library';
        $user = 'ts_user';
        $pass = 'pa55word';
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        try {
            $db = new PDO($dsn, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }
    return $db;
}
