<?php
include_once('connections.php');

if(isset($_SESSION['login'])) {
    $username = $_SESSION['username'];
    $query = mysqli_query($connection, "SELECT * FROM users WHERE username = '$username'");
    $user = mysqli_fetch_assoc($query);
}
?>