<?php

include_once('tomaraoConnection.php');
$qid = $_GET['qid'];

$delete = mysqli_query($renzo, "DELETE FROM `questions` WHERE `qid` = '$qid'");

if ($delete) {
    echo "<script> alert ('Deleted successfully!');
        window.location.href = '../admin/tomaraoListOfQuestions.php'; </script>";
} else {
    echo "<script> alert ('Failed to delete the question, please try again later.'.);
    window.location.href = '../admin/tomaraoListOfQuestions.php'; </script> ";
}
