<?php
// Determine if we're running on the local (development) server or production (live) server.
if (in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1'])) {
    // Development configuration
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "hpl"; // Change as needed for your dev database
} else {
    // Production configuration
    $servername = "sql300.infinityfree.com";
    $username   = "if0_38196116";
    $password   = "12345";
    $dbname     = "if0_38196116_hpl";
}

// Create connection using the chosen configuration
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set timezone
date_default_timezone_set('Asia/Manila');
?>
