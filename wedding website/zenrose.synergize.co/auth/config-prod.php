<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "wedding";

try {
   
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection again
    if ($conn->connect_error) {
        echo "<script>
        console.log('failed to connect to database'); </script>";
    }

    echo "<script>
    console.log('connected to database'); </script>";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
