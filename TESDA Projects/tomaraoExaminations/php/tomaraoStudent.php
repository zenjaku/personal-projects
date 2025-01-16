<?php
include_once('tomaraoConnection.php');

if (isset($_GET['tomarao_Id'])) {
    $id = $_GET['tomarao_Id'];

    $search_users = mysqli_query($tomarao, "UPDATE `registration` SET `tomarao_Status` = 1 WHERE `tomarao_Id` = '$id'");

    if ($search_users) {
        echo '<script> alert("Student approved successfully"); window.location.href = "../admin/tomaraoStudents.php"; </script>';
    } else {
        echo '<script> alert("Failed to approve the Client."); window.location.href = "../admin/tomaraoStudents.php"; </script>';
    }
}
