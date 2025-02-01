<?php
include '../connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $transferID = mysqli_real_escape_string($conn, $_POST['transferID']);

    // Corrected SQL Query
    $sql = "
        SELECT assets.assets_id, assets.assets, assets.brand, assets.model, assets.sn
        FROM assets
        INNER JOIN computer ON assets.assets_id = computer.assets_id
        INNER JOIN allocation ON computer.cname_id = allocation.cname_id
        WHERE allocation.employee_id = '$transferID'
    ";

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