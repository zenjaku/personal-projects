<?php
include '../connections.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // Query the database to select based on cname instead of sn
    $sql = "SELECT * FROM computer WHERE cname LIKE '$name%' OR cname_id LIKE '$name%' GROUP BY cname";
    $query = mysqli_query($conn, $sql);

    // Initialize an array to hold the data
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'cname_id' => $row['cname_id'],
            'cname' => $row['cname'],
        ];
    }

    // If no results are found, handle accordingly
    if (empty($data)) {
        echo json_encode(['message' => 'No assets found']);
    } else {
        echo json_encode($data); // Return the data as JSON
    }
}
?>