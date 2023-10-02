<?php
session_start();

// Include your database connection code here
$conn = new mysqli("localhost", "root", "", "login_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input data from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the username and password match your database records
$query = "SELECT id FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Generate a unique session ID
    $session_id = uniqid();

    // Store the session ID in the database
    $user_id = $stmt->fetch_assoc()['id'];
    $insert_query = "INSERT INTO sessions (user_id, session_id) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("ss", $user_id, $session_id);
    $insert_stmt->execute();

    // Set the session ID as a cookie
    setcookie("session_id", $session_id, time() + 999999999999999, "/"); // Set the expiration time as needed

    // Redirect the user to a protected page
    header("Location: dashboard.php");
} else {
    // Redirect the user back to the login page with an error message
    $_SESSION['login_error'] = "Invalid username or password";
    header("Location: login.php");
}

$stmt->close();
$insert_stmt->close();
$conn->close();
?>
