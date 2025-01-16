<?php
include_once('connections.php');
session_start();

$username = $_GET['username'];

$update = mysqli_query($connection, "UPDATE users SET status = '1' WHERE username = '$username'");

if($update){
    $_SESSION['status'] = 'success';
    $_SESSION['success'] = 'User approved successfully.';
    echo '<script>
    window.location.href = "../admin/clients.php";
    </script>';
    return;
} else {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Failed to approve the user, please try again later.';
    echo '<script>
    window.location.href = "../admin/clients.php";
    </script>';
    return;
}
?>