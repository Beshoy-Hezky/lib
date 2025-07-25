<h1>Welcome to the E-Library</h1>
<p>Browse our collection of books.</p>
<ul>
<?php foreach ($books as $b): ?>
    <li><a href="index.php?page=book&id=<?php echo $b['id']; ?>">
        <?php echo htmlspecialchars($b['title']); ?></a> by <?php echo htmlspecialchars($b['author']); ?>
    </li>
<?php endforeach; ?>
</ul>
