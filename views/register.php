<h1>Register</h1>
<form method="post" action="index.php?page=register">
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Register</button>
</form>
<p><?php echo $message; ?></p>
