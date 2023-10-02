<?php
session_start();
if (!isset($_COOKIE['session_id'])) {
    header("Location: not_found.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to the Dashboard</h2>
    <p>This is a protected page.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
