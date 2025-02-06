<?php
// Load the .env file
require_once '../vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__ . '/../admin/')->load();

session_start();

// Fetch credentials from the environment
$validUsername = $_ENV['DB_USERNAME'];
$validPasswordHash = $_ENV['DB_PASSWORD'];

// Handle the login process
if (isset($_POST['login'])) {
    // Trim and sanitize user input
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    // Validate the username
    if ($inputUsername !== $validUsername) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Incorrect username';
        header("Location: /login");
        exit();
    }

    // Validate the password securely
    if (!password_verify($inputPassword, $validPasswordHash)) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Incorrect password';
        header("Location: /login");
        exit();
    }

    // Successful login: regenerate session ID for security
    session_regenerate_id(true);  // Prevent session fixation

    // Set session variables for logged-in user
    $_SESSION['login'] = true;
    $_SESSION['username'] = $validUsername;
    $_SESSION['status'] = 'success';
    $_SESSION['success'] = "Welcome, $validUsername";

    // Redirect to the homepage after successful login
    echo "<script> parent.location.href='/'; </script>";
}
?>