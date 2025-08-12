<h1>Dashboard</h1>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['role']); ?> user.</p>

<?php if ($_SESSION['role'] === 'admin'): ?>
    <form method="get" action="index.php">
        <input type="hidden" name="page" value="add_book">
        <button type="submit">Add Book</button>
    </form>
    <table>
        <tr><th>Title</th><th>Actions</th></tr>
        <?php foreach ($books as $b): ?>
        <tr>
            <td><?php echo htmlspecialchars($b['title']); ?></td>
            <td>
                <form method="get" action="index.php" style="display:inline">
                    <input type="hidden" name="page" value="edit_book">
                    <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
                    <button type="submit">Edit</button>
                </form>
                <form method="get" action="index.php" style="display:inline" onsubmit="return confirm('Delete book?');">
                    <input type="hidden" name="page" value="delete_book">
                    <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <h2>Your Borrowed Books</h2>
    <table>
        <tr><th>Title</th><th>Author</th><th>Return</th></tr>
        <?php foreach ($borrowings as $b): ?>
        <tr>
            <td><?php echo htmlspecialchars($b['title']); ?></td>
            <td><?php echo htmlspecialchars($b['author']); ?></td>
            <td>
                <form method="get" action="index.php" style="display:inline">
                    <input type="hidden" name="page" value="return_book">
                    <input type="hidden" name="id" value="<?php echo $b['borrow_id']; ?>">
                    <button type="submit">Return</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
