<?php
// Load the .env file
require_once '../vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

// Start the session
session_start();

// Fetch credentials from the environment

$validUsername = $_ENV['DB_USERNAME'];
$validPasswordHash = $_ENV['DB_PASSWORD'];

// Handle the login process
if (isset($_POST['login'])) {
    include 'create_tbl.php';
    // Trim and sanitize user input
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    // Validate the username
    if ($inputUsername !== $validUsername) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Incorrect username';
        header("Location: ../index.php?page=login");
        exit();
    }

    // Validate the password securely
    if (!password_verify($inputPassword, $validPasswordHash)) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Incorrect password';
        header("Location: ../index.php?page=login");
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
    echo "<script> parent.location.href='../index.php'; </script>";
}
?>