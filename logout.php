<?php
session_start();
if (isset($_COOKIE['session_id'])) {
    // Remove the session ID from the database
    $conn = new mysqli("localhost", "root", "", "login_system");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $session_id = $_COOKIE['session_id'];
    $delete_query = "DELETE FROM sessions WHERE session_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("s", $session_id);
    $delete_stmt->execute();

    // Expire the session ID cookie
    setcookie("session_id", "", time() - 3600, "/"); // Expire immediately

    $delete_stmt->close();
    $conn->close();
}

// Redirect the user to the login page
header("Location: login.php");
?>
