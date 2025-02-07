<?php
session_start();
require_once "connections.php"; // Ensure database connection is included

// Handle the login process
if (isset($_POST['login'])) {
    // Trim and sanitize user input
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $users = $result->fetch_assoc();

        // Verify password
        if (!password_verify($inputPassword, $users["password"])) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Incorrect password';
            // header("Location: /login");
            echo "<script> window.location = '/login'; </script>";
            exit();
        }

        // Check if account is activated (status 1)
        if ($users['status'] !== 1) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Your account has not been activated yet. Please contact the administrator for assistance.';
            // header("Location: /login");
            echo "<script> window.location = '/login'; </script>";
            exit();
        }

        // Successful login: regenerate session ID for security
        session_regenerate_id(true); // Prevent session fixation

        // Set session variables for logged-in user
        $_SESSION['login'] = true;
        $_SESSION['username'] = $users['username']; // Use fetched username
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = "Welcome, " . htmlspecialchars($users['username']);

        // Redirect to homepage after successful login
        // header("Location: /");
        echo "<script> window.location = '/'; </script>";
        exit();
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Username does not match any in our system.';
        // header("Location: /login");
        echo "<script> window.location = '/login'; </script>";
        exit();
    }
}
?>