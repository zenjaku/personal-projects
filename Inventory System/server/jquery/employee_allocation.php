<?php
include '../connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $assetID = mysqli_real_escape_string($conn, $_POST['assetID']);

    // Query to get all assets that correspond to the cname selected in the computer table
    $sql = "SELECT * FROM assets WHERE assets_id IN (SELECT assets_id FROM computer WHERE cname_id = '$assetID')";
    $query = mysqli_query($conn, $sql);

    // Initialize an array to hold the data
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'assets_id' => $row['assets_id'],
            'assets' => $row['assets'], 
            'brand' => $row['brand'],
            'model' => $row['model'],
            'sn' => $row['sn'],
        ];
    }

    // Return JSON response
    if (empty($data)) {
        echo json_encode(['message' => 'No assets found']);
    } else {
        echo json_encode($data);  // Return the assets data
    }
}
?>
