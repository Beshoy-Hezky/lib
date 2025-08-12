<h1>Welcome to the E-Library</h1>
<p>Browse our collection of books.</p>
<ul>
<?php foreach ($books as $b): ?>
    <li>
        <form method="get" action="index.php" style="display:inline">
            <input type="hidden" name="page" value="book">
            <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
            <button type="submit"><?php echo htmlspecialchars($b['title']); ?></button>
        </form>
        by <?php echo htmlspecialchars($b['author']); ?>
    </li>
<?php endforeach; ?>
</ul>
