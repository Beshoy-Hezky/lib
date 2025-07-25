<h1>Add Book</h1>
<form method="post" action="index.php?page=add_book">
    <label>Title: <input type="text" name="title" required></label><br>
    <label>Author: <input type="text" name="author" required></label><br>
    <label>Category: <input type="text" name="category"></label><br>
    <label>ISBN: <input type="text" name="isbn"></label><br>
    <button type="submit">Add</button>
</form>
<p><?php echo $message; ?></p>
