<?php
require_once __DIR__ . '/db.php';

function get_books($search = '', $order = 'title', $available_only = false) {
    $db = get_db();
    $sql = "SELECT b.* FROM books b";
    if ($available_only) {
        $sql .= " LEFT JOIN borrowings br ON b.id = br.book_id AND br.return_date IS NULL";
    }
    $sql .= " WHERE 1=1";
    $params = array();
    if ($available_only) {
        $sql .= " AND br.id IS NULL";
    }
    if ($search != '') {
        $sql .= " AND (b.title LIKE ? OR b.author LIKE ? OR b.category LIKE ?)";
        $wild = '%' . $search . '%';
        $params[] = $wild;
        $params[] = $wild;
        $params[] = $wild;
    }
    if ($order != 'author' && $order != 'category') {
        $order = 'title';
    }
    $sql .= " ORDER BY b.$order";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_book($id) {
    $db = get_db();
    $stmt = $db->prepare('SELECT * FROM books WHERE id = ?');
    $stmt->execute(array($id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function add_book($title, $author, $category, $isbn) {
    $db = get_db();
    $stmt = $db->prepare('INSERT INTO books (title, author, category, isbn) VALUES (?, ?, ?, ?)');
    return $stmt->execute(array($title, $author, $category, $isbn));
}

function update_book($id, $title, $author, $category, $isbn) {
    $db = get_db();
    $stmt = $db->prepare('UPDATE books SET title = ?, author = ?, category = ?, isbn = ? WHERE id = ?');
    return $stmt->execute(array($title, $author, $category, $isbn, $id));
}

function delete_book($id) {
    $db = get_db();
    $stmt = $db->prepare('DELETE FROM books WHERE id = ?');
    return $stmt->execute(array($id));
}
