<?php if ($book): ?>
<h1><?php echo htmlspecialchars($book['title']); ?></h1>
<p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
<p>Category: <?php echo htmlspecialchars($book['category']); ?></p>
<p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
<?php if (isset($_SESSION['user_id'])): ?>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <form method="get" action="index.php" style="display:inline">
            <input type="hidden" name="page" value="edit_book">
            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
            <button type="submit">Edit</button>
        </form>
        <form method="get" action="index.php" style="display:inline" onsubmit="return confirm('Delete book?');">
            <input type="hidden" name="page" value="delete_book">
            <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
            <button type="submit">Delete</button>
        </form>
    <?php else: ?>
        <?php if ($user_borrow_id): ?>
            <form method="get" action="index.php">
                <input type="hidden" name="page" value="return_book">
                <input type="hidden" name="id" value="<?php echo $user_borrow_id; ?>">
                <button type="submit">Return Book</button>
            </form>
        <?php elseif (!$is_borrowed): ?>
            <form method="get" action="index.php">
                <input type="hidden" name="page" value="borrow_book">
                <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
                <button type="submit">Borrow Book</button>
            </form>
        <?php else: ?>
            <p>This book is currently borrowed.</p>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
<?php else: ?>
<p>Book not found.</p>
<?php endif; ?>
