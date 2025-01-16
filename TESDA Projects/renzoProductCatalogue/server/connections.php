<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "product_catalogue";

$connection = mysqli_connect($servername, $username, $password, $dbname);

if($connection->connect_error) {
    die("Connection Failed: ". $connection->connect_error);
}