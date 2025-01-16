<?php
include_once('connections.php');
session_start();

if (isset($_POST['login'])) {
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];

    $login = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
    $query = mysqli_fetch_assoc($login);

    if (mysqli_num_rows($login) > 0) {
        if ($password == $query['password']) {

            //admin login
            if ($query['status'] == '1') {
                if ($query['type'] == '1') {
                    $_SESSION['login'] = true;
                    $_SESSION['type'] = $query['type'];
                    $_SESSION['username'] = $query['username'];
                    unset($_SESSION['status_shown']);
                    $_SESSION['status'] = 'success';
                    $_SESSION['success'] = 'Welcome back' . ', &nbsp;' . $username . '!';
                    echo "<script> parent.location.href = '../index.php'; </script>";
                }
                // customer login
                else {
                    $_SESSION['status'] = 'success';
                    $_SESSION['success'] = 'Welcome back' . ', &nbsp;' . $username . '!';
                    $_SESSION['login'] = true;
                    $_SESSION['type'] = $query['type'];
                    $_SESSION['username'] = $query['username'];
                    unset($_SESSION['status_shown']);
                    echo "<script> parent.location.href = '../index.php'; </script>";
                }

            } else {
                // inactive account
                $_SESSION['status'] = 'failed';
                $_SESSION['failed'] = 'Your account is still inactive, please contact the administrator.';
                // echo "<script> alert ('Your account is still inactive, please contact the administrator.');
                // history.back();</script>";
                echo "<script> history.back(); </script>";
                exit();
            }
        } else {
            // incorrect password
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Incorrect password.';
            // echo "<script> alert ('Incorrect password.');
            // history.back();</script>";
            echo "<script> history.back(); </script>";
            exit();
        }
    } else {
        // account not found
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Account not found.';
        // echo "<script> alert ('Account not found.');
        // window.location.href = '../auth/register.php';</script>";
        echo "<script> window.location.href = '../auth/register.php'; </script>";
        exit();
    }
}