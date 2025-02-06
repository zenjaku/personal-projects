<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "db_exam";

$conn = new mysqli($servername, $username, $password, $db);

if($conn->connect_error) {
    echo "<script> console.log('Failed to connect to database'); </script>";
} else {
    echo "<script> console.log('Connected to database'); </script>";
}

?>