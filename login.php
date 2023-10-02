<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h2>Login</h2>
    <form action="login_process.php" method="post">
        <label for="username">Usernames:</label>
        <input type="text" name="username" required><br><br>
        <label for="password">Passwords:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>

    <a href="register.php">Register</a>
</body>
</html>