<?php
include_once "tomaraoConnection.php";
session_start();

$studentId = $_SESSION['tomarao_Id'];
if(isset($_POST["send_feedback"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = htmlspecialchars($_POST['subject']);
    $feedback = htmlspecialchars($_POST['feedback']);
    $date = date('Y-m-d');
    date_default_timezone_set('Asia/Manila'); 
    $time = date( 'h:i:s A');

    $storeFeedback = mysqli_query($renzo, "INSERT INTO feedback (userId, name, email, subject, feedback, date, time)
                VALUES ('$studentId', '$name', '$email', '$subject', '$feedback', '$date', '$time')");

    if(!$storeFeedback) {
        echo "<script> alert ('Something went wrong, please try again.'); </script>";
    } else {
        echo "<script> alert ('Feedback sent!');
                window.location.href = '../students/tomaraoAvailableTests.php'; </script>";
    }

}

$renzo->close();