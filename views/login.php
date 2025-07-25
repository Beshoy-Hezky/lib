<h1>Login</h1>
<form method="post" action="index.php?page=login">
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
</form>
<p><?php echo $message; ?></p>
