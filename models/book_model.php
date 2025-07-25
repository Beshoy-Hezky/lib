<?php
require_once __DIR__ . '/db.php';

function get_books($search = '', $order = 'title') {
    $db = get_db();
    $sql = 'SELECT * FROM books';
    $params = [];
    if ($search !== '') {
        $sql .= ' WHERE title LIKE ? OR author LIKE ? OR category LIKE ?';
        $wild = '%' . $search . '%';
        $params = [$wild, $wild, $wild];
    }
    $allowed = ['title', 'author', 'category'];
    if (!in_array($order, $allowed)) {
        $order = 'title';
    }
    $sql .= " ORDER BY $order";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_book($id) {
    $db = get_db();
    $stmt = $db->prepare('SELECT * FROM books WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_book($title, $author, $category, $isbn) {
    $db = get_db();
    $stmt = $db->prepare('INSERT INTO books (title, author, category, isbn) VALUES (?, ?, ?, ?)');
    return $stmt->execute([$title, $author, $category, $isbn]);
}

function update_book($id, $title, $author, $category, $isbn) {
    $db = get_db();
    $stmt = $db->prepare('UPDATE books SET title = ?, author = ?, category = ?, isbn = ? WHERE id = ?');
    return $stmt->execute([$title, $author, $category, $isbn, $id]);
}

function delete_book($id) {
    $db = get_db();
    $stmt = $db->prepare('DELETE FROM books WHERE id = ?');
    return $stmt->execute([$id]);
}
