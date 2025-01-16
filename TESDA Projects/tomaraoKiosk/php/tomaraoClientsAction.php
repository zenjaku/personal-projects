<?php
include_once('tomaraoConnection.php');
$id = $_GET['id'];

$search_users = mysqli_query($tomarao, "UPDATE `tomaraoregistration` SET `tomarao_status` = 1 WHERE `id` = '$id' ");

if ($search_users) {
    echo '<script> alert ("Client approved successfully");
        window.location.href = "../tomaraoClients.php"; </script>';
} else {
    echo '<script> alert ("Failed to approve the Client.");
        window.location.href = "../tomaraoClients.php"; </script>';
}