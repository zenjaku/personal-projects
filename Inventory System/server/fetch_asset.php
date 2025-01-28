<?php
include '../server/connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = mysqli_real_escape_string($conn, $_POST['sn']);

    // Query the database
    $sql = "SELECT * FROM assets WHERE sn LIKE '$name%'";
    $query = mysqli_query($conn, $sql);

    // Initialize an array to hold the data
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'assets_id' => $row['assets_id'],
            // 'assets' => $row['assets'],
            'brand' => $row['brand'],
            'model' => $row['model'],
            // 'sn' => $row['sn'],
        ];
    }

    // If no results are found, handle accordingly
    if (empty($data)) {
        echo json_encode(['message' => 'No assets found']);
    } else {
        echo json_encode($data); // Return the data as JSON
    }
}