<?php
// Determine if the environment is local or production
$is_local = ($_SERVER['HTTP_HOST'] === 'localhost');

// Database credentials for local and production
if ($is_local) {
    // Local configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "wedding";
} else {
    // Production configuration
    $servername = "sql208.infinityfree.com";
    $username = "if0_37571100";
    $password = "Persephone1997";
    $dbname = "if0_37571100_zenrose";
}

try {
    if ($is_local) {
        // Ensure the database exists (local environment only)
        $conn = new mysqli($servername, $username, $password);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $db_check_query = "SHOW DATABASES LIKE '$dbname'";
        $result = $conn->query($db_check_query);

        if ($result->num_rows === 0) {
            $create_db_query = "CREATE DATABASE $dbname";
            if ($conn->query($create_db_query) === TRUE) {
                echo "<script>console.log('Database created');</script>";
            } else {
                echo "<script>console.log('Failed to create database');</script>";
            }
        }

        $conn->close();
    }

    // Connect to the selected database
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo "<script>console.log('Failed to connect to database');</script>";
    } else {
        echo "<script>console.log('Connected to database');</script>";
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
