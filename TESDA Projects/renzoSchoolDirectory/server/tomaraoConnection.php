<?php
$server = 'localhost';
$username = 'root';
$password = '';
$db = 'schoolDirectory';

$renzo = new mysqli($server, $username, $password);

if ($renzo->connect_error) {
    die("<script>console.log('Connection Failed');</script>");
}

$database_check = "SHOW DATABASES LIKE '$db'";
$result = $renzo->query($database_check);

if ($result->num_rows === 0) {
    $create_db = "CREATE DATABASE $db";

    if ($renzo->query($create_db) === TRUE) {
        echo '<script>console.log("Database created!");</script>';
    } else {
        echo '<script>console.log("Failed to create database!");</script>';
    }
}

$renzo = new mysqli($server, $username, $password, $db);

if ($renzo->connect_error) {
    echo "<script>console.log('Failed to connect to database');</script>";
} else {
    echo "<script>console.log('Connected to database');</script>";
}