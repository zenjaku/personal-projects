<?php
session_start();
include_once("connection.php");

if (isset($_POST["REGISTER"])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $address = trim($_POST['address']);
    $contact = trim($_POST['contact']);
    $type = 0;
    $status = 0;

    function strongPassword($password)
    {
        if (strlen($password) < 8) {
            return false;
        }
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }
        if (!preg_match('/[\W_]/', $password)) {
            return false;
        }

        return true;
    }

    if ($password !== $confirmPassword) {
        $_SESSION['status'] = 'notMatch';
        $_SESSION['notMatch'] = "Password do not match!";
    } elseif (!strongPassword($password)) {
        $_SESSION['status'] = 'notStrong';
        $_SESSION['notStrong'] = "Password must be at least 8 characters long and include uppercase letters, lowercase letters, numbers, and special characters.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $_SESSION['status'] = 'match';
        $_SESSION['match'] = "Password Matched";

        $stmt = $conn->prepare('SELECT _id FROM user WHERE username = ? OR email = ?');
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Username or email already in use.';
            header('location: ../index.php');
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO user (name, email, username, password, address, contact, type, status) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss", $name, $email, $username, $hashedPassword, $address, $contact, $type, $status);

        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = "Registered Successfully";
            header('location: ../index.php');
            exit();
        } else {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = "Please try again";
            header('location: ../index.php');
            exit();

        }

    }

}

$conn->close();