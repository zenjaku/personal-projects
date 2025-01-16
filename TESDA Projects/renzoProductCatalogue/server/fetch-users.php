<?php
include_once('connections.php');
// session_start();

$fetchUsers = "SELECT * FROM users";
$clients = mysqli_query($connection, $fetchUsers);
?>