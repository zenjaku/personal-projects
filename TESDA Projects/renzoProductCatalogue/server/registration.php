<?php
session_start();
include_once('connections.php');

if (isset($_POST['register'])) {
    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];
    $email = $_REQUEST['email'];
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $number = $_REQUEST['number'];
    $street = $_REQUEST['street'];
    $barangay = $_REQUEST['barangay'];
    $municipality = $_REQUEST['municipality'];
    $province = $_REQUEST['province'];
    $zipcode = $_REQUEST['zipcode'];
    $type = '0';
    $status = '0';
    $created_at = date('Y-m-d H:i:s');

    // if (!$email && !$username && !$userId) {
    //     echo "<script> alert ('Email address is not available.');
    //         window.location.href = '../auth/register.php';</script>";
    // }

    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $checkEmail);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Email address is already registered.';
        // echo "<script> alert ('Email address is already registered.');
        //     window.location.href = '../auth/register.php';</script>";
        echo "<script>window.location.href = '../auth/register.php';</script>";
        return;
    }

    $checkUsername = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $checkUsername);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Username is already registered.';
        // echo "<script> alert ('Username is already registered.');
        //     window.location.href = '../auth/register.php';</script>";
        echo "<script>window.location.href = '../auth/register.php';</script>";
        return;
    }

    $cPassword = $_REQUEST['cPassword'];
    if ($password !== $cPassword) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Passwords do not match.';
        // echo "<script>
        //     alert('Passwords do not match.');
        //     history.back();
        //     </script>";
        echo "<script>window.location.href = '../auth/register.php';</script>";
        return;
    }

    $currentYear = date('Y');
    $userId = $currentYear . '-' . $email;

    $register = "INSERT INTO users (userId,
                                    fname,
                                    lname,
                                    email,
                                    username,
                                    password,
                                    number,
                                    street,
                                    barangay,
                                    municipality,
                                    province,
                                    zipcode,
                                    type,
                                    status,
                                    created_at)
                            VALUES ('$userId',
                                    '$fname',
                                    '$lname',
                                    '$email',
                                    '$username',
                                    '$password',
                                    '$number',
                                    '$street',
                                    '$barangay',
                                    '$municipality',
                                    '$province',
                                    '$zipcode',
                                    '$type',
                                    '$status',
                                    '$created_at') ";

    try {
        $result = mysqli_query($connection, $register);

        if (!$result) {
            $_SESSION['status'] = 'failed'; 
            $_SESSION['failed'] = 'Failed to create an account, please try again later.';
            // echo "<script> alert ('Failed to create an account, please try again later.');
            //     window.location.href = '../auth/register.php'; </script>";
            echo "<script>window.location.href = '../auth/register.php';</script>";
            return;
        } else {
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = 'Account created successfully, please wait for the administrator to activate your account.';
            // echo "<script> alert ('Account created successfully, please wait for the administrator to activate your account.');
            //             parent.location.href = '../index.php'; </script>";
            echo "<script>window.location.href = '../components/main.php';</script>";
            return;
        }

    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Email address is already registered.';
            // echo "<script> alert ('Email address is already registered.');
            //     window.location.href = '../auth/register.php'; </script>";
            echo "<script>window.location.href = '../auth/register.php';</script>";
            return;
        } else {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'An error occurred. Please try again later.';
            // echo "<script> alert ('An error occurred. Please try again later.');
            //     window.location.href = '../auth/register.php'; </script>";
            echo "<script>window.location.href = '../auth/register.php';</script>";
            return;
        }
    }

}

mysqli_close($connection);
?>