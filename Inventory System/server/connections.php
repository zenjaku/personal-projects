<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

$db = $conn->select_db("hpl") ? "hpl" : ($conn->select_db("db_exam") ? "db_exam" : null);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>