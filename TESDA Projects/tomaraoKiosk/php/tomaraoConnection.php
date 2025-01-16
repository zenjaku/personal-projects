<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "tomaraokiosk";

$tomarao = mysqli_connect("$servername","$username","$password","$database");

if ($tomarao->connect_error) {
	die ("Connection failed: " . $tomarao->connect_error);
}

?>