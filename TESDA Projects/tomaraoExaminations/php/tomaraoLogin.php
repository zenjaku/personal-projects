<?php

include_once "tomaraoConnection.php";
session_start();

if (isset($_POST["LOGIN"])) {
    $tomarao_Username = $_POST["tomarao_Username"];
    $tomarao_Password = $_POST["tomarao_Password"];

    $checkUsername = mysqli_query($tomarao, "SELECT * FROM registration WHERE tomarao_Username = '$tomarao_Username'");

    if (mysqli_num_rows($checkUsername) == 0) {
        echo "<script> alert('Oops! You are not register, please register first.');
                        window.location.href = '../tomaraoRegistration.php'; </script>";
        return;
    }

    $row = mysqli_fetch_array($checkUsername);

    if ($tomarao_Password != $row['tomarao_Password']) {
        echo "<script> alert('Oops! The username or password you entered is incorrect.');
                        window.location.href = '../tomaraoLogin.php'; </script>";
        return;
    }

    if ($row['tomarao_Status'] == 0) {
        echo "<script> alert('Oops! Your account is currently inactive.');
                        window.location.href = '../tomaraoLogin.php'; </script>";
        return;
    }

    $_SESSION['login'] = true;
    $_SESSION['tomarao_Id'] = $row['tomarao_Id'];
    $_SESSION["USER"] = $row;
    $_SESSION['tomarao_Type'] = $row['tomarao_Type'];
    echo "<script> parent.location.href = '../tomaraoMainPage.php'; </script>";

    $tomarao_Email = $row['tomarao_Email'];
    if ($row['tomarao_Type'] == '1') {
        $checkEmail = mysqli_query($renzo, "SELECT * FROM admin WHERE email = '$tomarao_Email' and username = '$tomarao_Username'");

        if (mysqli_num_rows($checkEmail) == 0) {
            $save = mysqli_query($renzo, "INSERT INTO admin (username, email, password) VALUES ('$tomarao_Username', '$tomarao_Email', '$tomarao_Password')");

            if (!$save) {
                return;
            }
        }
    }
}

mysqli_close($tomarao);
mysqli_close($renzo);
