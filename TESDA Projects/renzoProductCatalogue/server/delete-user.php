<?php
include_once('connections.php');
session_start();

$userId = $_GET['userId'];

$delete = mysqli_query($connection, "DELETE FROM users WHERE userId = '$userId'");

if($delete){
    $_SESSION['status'] = 'success';
    $_SESSION['success'] = 'Account successfully deleted.';
    echo '<script>
    window.location.href = "../admin/clients.php";
    </script>';
    return;
} else {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Failed to delete the account, please try again later.';
    echo '<script>
    window.location.href = "../admin/clients.php";
    </script>';
    return;
}
?>