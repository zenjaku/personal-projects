<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tomarao_examination";

$tomarao = mysqli_connect($servername, $username, $password, $dbname);

if($tomarao->connect_error) {
    die("Connection Failed: ". $tomarao->connect_error);
}


$servername1 = "localhost";
$username1 = "root";
$password1 = "";
$dbname1 = "adminExam";


$renzo = mysqli_connect($servername1, $username1, $password1, $dbname1);

if($renzo->connect_error) {
    die("Connection Failed: ". $renzo->connect_error);
}