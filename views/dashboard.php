<h1>Dashboard</h1>
<p>Welcome, <?php echo htmlspecialchars($_SESSION['role']); ?> user.</p>
<a href="index.php?page=add_book">Add Book</a>
<table>
    <tr><th>Title</th><th>Actions</th></tr>
    <?php foreach ($books as $b): ?>
    <tr>
        <td><?php echo htmlspecialchars($b['title']); ?></td>
        <td>
            <a href="index.php?page=edit_book&id=<?php echo $b['id']; ?>">Edit</a>
            <a href="index.php?page=delete_book&id=<?php echo $b['id']; ?>" onclick="return confirm('Delete book?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
