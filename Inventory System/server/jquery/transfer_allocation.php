<?php
include '../connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $transferID = mysqli_real_escape_string($conn, $_POST['transferID']);

    // Step 1: Get serialized assets_id from the computer table
    $computerQuery = "SELECT assets_id FROM computer WHERE cname_id IN 
                      (SELECT cname_id FROM allocation WHERE employee_id = '$transferID' AND status = 1)";
    $computerResult = mysqli_query($conn, $computerQuery);

    $allAssets = [];
    while ($row = mysqli_fetch_assoc($computerResult)) {
        // Unserialize the stored assets_id
        $assetsArray = unserialize($row['assets_id']);
        if (is_array($assetsArray)) {
            $allAssets = array_merge($allAssets, $assetsArray);
        }
    }

    // Step 2: Ensure there are assets to search for
    if (empty($allAssets)) {
        echo json_encode(['message' => 'No assets found']);
        exit();
    }

    // Step 3: Prepare a safe SQL query
    $assetsList = "'" . implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($allAssets), $conn), $allAssets)) . "'";
    $sql = "SELECT assets_id, assets, brand, model, sn FROM assets WHERE assets_id IN ($assetsList)";

    $query = mysqli_query($conn, $sql);

    // Step 4: Fetch and return data
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

    echo empty($data) ? json_encode(['message' => 'No assets found']) : json_encode($data);
}

?>