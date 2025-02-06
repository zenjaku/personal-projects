<?php
session_start();
include_once("connection.php");

if (isset($_POST["LOGIN"])) {
    // Prepare a secure SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();

    if ($rows) { // Check if the user exists
        if (password_verify($_POST['password'], $rows["password"])) {
            // Check if the account is active
            if ($rows["status"] == 1) {
                // Store user information in session
                $_SESSION["login"] = true;
                $_SESSION["userId"] = $rows["id"]; // Storing userId
                $_SESSION["type"] = $rows["type"];

                // Redirect based on user type
                header("location: ../index.php");
                exit();
            } else {
                $_SESSION['status'] = 'inactive';
                $_SESSION['inactive'] = "Your account is currently inactive, please try again later or contact the administrator.";
                header("location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['status'] = 'incorrect';
            $_SESSION['incorrect'] = "Incorrect password, please try again.";
            header("location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['status'] = 'notRegistered';
        $_SESSION['notRegistered'] = "Username or email is not registered.";
        header("location: ../index.php");
        exit();
    }

}

$conn->close();