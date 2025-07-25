<h1>Book List</h1>
<form method="get" action="index.php">
    <input type="hidden" name="page" value="books">
    <input type="text" name="search" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>">
    <select name="order">
        <option value="title" <?php if ($order=='title') echo 'selected'; ?>>Title</option>
        <option value="author" <?php if ($order=='author') echo 'selected'; ?>>Author</option>
        <option value="category" <?php if ($order=='category') echo 'selected'; ?>>Category</option>
    </select>
    <button type="submit">Apply</button>
</form>
<table>
    <tr><th>Title</th><th>Author</th><th>Category</th></tr>
    <?php foreach ($books as $b): ?>
    <tr>
        <td><a href="index.php?page=book&id=<?php echo $b['id']; ?>"><?php echo htmlspecialchars($b['title']); ?></a></td>
        <td><?php echo htmlspecialchars($b['author']); ?></td>
        <td><?php echo htmlspecialchars($b['category']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
