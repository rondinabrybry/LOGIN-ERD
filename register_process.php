<?php
session_start();

// Include your database connection code here
$conn = new mysqli("localhost", "root", "", "login_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get input data from the registration form
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the username already exists in the database
$check_query = "SELECT id FROM users WHERE username = ?";
$check_stmt = $conn->prepare($check_query);
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    // Redirect the user back to the registration page with an error message
    $_SESSION['registration_error'] = "Username already exists. Please choose another username.";
    header("Location: register.php");
} else {
    // Insert the new user into the database
    $insert_query = "INSERT INTO users (username, password) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_query);

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_stmt->bind_param("ss", $username, $hashed_password);
    $insert_stmt->execute();

    // Redirect the user to the login page after successful registration
    header("Location: login.php");
}

$check_stmt->close();
$insert_stmt->close();
$conn->close();
?>
