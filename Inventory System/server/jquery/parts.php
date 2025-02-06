<?php
include '../connections.php';

$page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
$limit = 10;  // Number of records per page
$offset = ($page - 1) * $limit;

// Sanitize input for search
$name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';

// Step 1: Fetch all computer records
$computerQuery = mysqli_query($conn, "SELECT cname, cname_id, assets_id FROM computer");

$computerAssets = [];
while ($row = mysqli_fetch_assoc($computerQuery)) {
    $assetsArray = unserialize($row['assets_id']);
    if (is_array($assetsArray)) {
        foreach ($assetsArray as $asset) {
            $computerAssets[$asset] = [
                'cname' => $row['cname'],
                'cname_id' => $row['cname_id']
            ];
        }
    }
}

// Step 2: Fetch paginated asset data
$sql = "SELECT assets_id, assets, brand, model, sn FROM assets WHERE assets LIKE '$name%' OR brand LIKE '$name%' OR model LIKE '$name%' OR sn LIKE '$name%' ORDER BY assets LIMIT $limit OFFSET $offset";
$query = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $assetID = $row['assets_id'];

    // Check if the asset exists in the computer table
    if (isset($computerAssets[$assetID])) {
        $row['cname_id'] = $computerAssets[$assetID]['cname_id'];
        $row['cname'] = $computerAssets[$assetID]['cname'];
        $row['status'] = 'installed';
    } else {
        $row['cname_id'] = '';
        $row['cname'] = 'Available Part';
        $row['status'] = 'Available';
    }

    $data[] = $row;
}

// Step 3: Count total records for pagination
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM assets WHERE sn LIKE '$name%'");
$totalRows = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRows / $limit);

// Return data with pagination info
echo json_encode(['data' => $data, 'totalPages' => $totalPages]);
?>
