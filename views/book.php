<?php if ($book): ?>
<h1><?php echo htmlspecialchars($book['title']); ?></h1>
<p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
<p>Category: <?php echo htmlspecialchars($book['category']); ?></p>
<p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
<?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
    <a href="index.php?page=edit_book&id=<?php echo $book['id']; ?>">Edit</a>
    <a href="index.php?page=delete_book&id=<?php echo $book['id']; ?>" onclick="return confirm('Delete book?');">Delete</a>
<?php endif; ?>
<?php else: ?>
<p>Book not found.</p>
<?php endif; ?>
