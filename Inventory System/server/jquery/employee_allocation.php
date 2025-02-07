<?php
include '../connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $cname_id = mysqli_real_escape_string($conn, $_POST['assetID']);

    // Fetch the serialized assets_id from the computer table
    $sql = "SELECT assets_id FROM computer WHERE cname_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cname_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $computerData = $result->fetch_assoc();

    if ($computerData) {
        // Unserialize the assets_id field
        $assets_ids = unserialize($computerData['assets_id']);

        if (!empty($assets_ids)) {
            // Prepare placeholders for query
            $placeholders = implode(',', array_fill(0, count($assets_ids), '?'));

            // Fetch asset details
            $fetchAssets = $conn->prepare("
                SELECT assets_id, assets, brand, model, sn 
                FROM assets 
                WHERE assets_id IN ($placeholders)
            ");

            // Bind parameters dynamically
            $fetchAssets->bind_param(str_repeat('s', count($assets_ids)), ...$assets_ids);
            $fetchAssets->execute();
            $assetsResult = $fetchAssets->get_result();

            // Initialize an array to hold the data
            $data = [];
            while ($row = $assetsResult->fetch_assoc()) {
                $data[] = [
                    'assets_id' => $row['assets_id'],
                    'assets' => $row['assets'],
                    'brand' => $row['brand'],
                    'model' => $row['model'],
                    'sn' => $row['sn'],
                ];
            }

            // Return JSON response
            echo !empty($data) ? json_encode($data) : json_encode(['message' => 'No assets found']);
        } else {
            echo json_encode(['message' => 'No assets found']);
        }
    } else {
        echo json_encode(['message' => 'Computer not found']);
    }
}
?>