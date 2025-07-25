<h1>Edit Book</h1>
<form method="post" action="index.php?page=edit_book&id=<?php echo $book['id']; ?>">
    <label>Title: <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required></label><br>
    <label>Author: <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required></label><br>
    <label>Category: <input type="text" name="category" value="<?php echo htmlspecialchars($book['category']); ?>"></label><br>
    <label>ISBN: <input type="text" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>"></label><br>
    <button type="submit">Update</button>
</form>
<p><?php echo $message; ?></p>
