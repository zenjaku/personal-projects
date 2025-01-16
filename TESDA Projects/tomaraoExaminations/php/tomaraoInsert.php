<?php
include_once "tomaraoConnection.php";


function generateUniqueEid($connection)
{
    do {
        
        $studentId = bin2hex(random_bytes(10));

        $result = mysqli_query($connection, "SELECT 1 FROM registration WHERE tomarao_Id = '$studentId'");

    } while (mysqli_num_rows($result) > 0);

    return $studentId;
}


if (isset($_POST["SUBMIT"])) {
    $tomarao_Fname = $_POST["tomarao_Fname"];
    $tomarao_Lname = $_POST["tomarao_Lname"];
    $tomarao_Email = $_POST["tomarao_Email"];
    $tomarao_Username = $_POST["tomarao_Username"];
    $tomarao_Password = $_POST["tomarao_Password"];
    $tomarao_cPassword = $_POST["tomarao_cPassword"];
    $tomarao_Type = 0;
    $tomarao_Status = 0;

    $checkEmail = mysqli_query($tomarao, "SELECT * FROM registration WHERE tomarao_Email = '$tomarao_Email'");

    if (mysqli_num_rows($checkEmail) == 1) {
        echo "<script> alert ('Oops! The email address you entered already exists in our system.'); 
                window.location.href ='../tomaraoRegistration.php' </script>";
        return;
    }

    $checkUsername = mysqli_query($tomarao, "SELECT * FROM registration WHERE tomarao_Username = '$tomarao_Username'");

    if (mysqli_num_rows($checkUsername) == 1) {
        echo "<script> alert ('Oops! The Username you entered is not available.'); 
                window.location.href ='../tomaraoRegistration.php' </script>";
        return;
    }

    if ($tomarao_Password != $tomarao_cPassword) {
        echo "<script> alert ('Oops! the password is not matched.'); 
                window.location.href ='../tomaraoRegistration.php'; </script>";
        return;
    }

    
    $studentId = generateUniqueEid($tomarao);

    $registerUser = mysqli_query($tomarao, "INSERT INTO registration (tomarao_Id, tomarao_Fname, tomarao_Lname, tomarao_Email, tomarao_Username, tomarao_Password, tomarao_Type, tomarao_Status)
                    VALUES ('$studentId', '$tomarao_Fname', '$tomarao_Lname', '$tomarao_Email', '$tomarao_Username', '$tomarao_Password', '$tomarao_Type', '$tomarao_Status')");


    if (!$registerUser) {
        echo "<script> alert ('Oops! Something went wrong, please try again later!'); 
                window.location.href ='../tomaraoRegistration.php' </script>";
        return;
    }


    echo "<script> alert ('Congratulations! Your account has been successfully registered.'); 
        window.location.href ='../tomaraoLogin.php' </script>";
}

mysqli_close($tomarao);