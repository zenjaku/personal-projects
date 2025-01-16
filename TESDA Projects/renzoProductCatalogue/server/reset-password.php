<?php
include_once 'connections.php';
session_start();
if(isset($_POST['update-password'])) {
    $password = $_REQUEST['newPassword'];
    $email = $_SESSION['reset_email'];

    $confirmPassword = $_REQUEST['cNewPassword'];
    $oldPassword = $_REQUEST['oldPassword'];

    $checkPassword = "SELECT password FROM users WHERE email = '$email'";
    $checkPasswordQuery = mysqli_query($connection, $checkPassword);
    $checkPasswordRow = mysqli_fetch_assoc($checkPasswordQuery);
    $checkPassword = $checkPasswordRow['password'];

    if($oldPassword !== $checkPassword) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Password do not match in the system.';
        echo "<script> window.location.href = '../auth/forgot-password.php'; </script>";
        return;
    }

    if($password !== $confirmPassword) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Password do not match.';
        echo "<script> window.location.href = '../auth/forgot-password.php'; </script>";
        return;
    }

    $updatePassword = "UPDATE users SET password = '$password' WHERE email = '$email'";
    $updatePasswordQuery = mysqli_query($connection, $updatePassword);
    if(!$updatePasswordQuery) {
        
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to update password.';
        echo "<script> window.location.href = '../auth/forgot-password.php'; </script>";
        return;
    } else {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Password updated successfully.';
        echo "<script> window.location.href = '../auth/login.php'; </script>";

    }
}