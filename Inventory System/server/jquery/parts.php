<?php
include '../connections.php';

$page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
$limit = 10;  // Number of records per page
$offset = ($page - 1) * $limit;

// Sanitize input for search
$name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';

// Query the database with pagination and join with the computer table
$sql = "
    SELECT assets.assets_id, assets.assets, assets.brand, assets.model, assets.sn, 
           computer.cname, computer.cname_id, 
           IFNULL(allocation.cname_id, '') AS allocated
    FROM assets
    LEFT JOIN computer ON assets.assets_id = computer.assets_id
    LEFT JOIN allocation ON allocation.cname_id = computer.cname_id
    WHERE assets.sn LIKE '$name%'
    LIMIT $limit OFFSET $offset
";
$query = mysqli_query($conn, $sql);

// Fetch the data
$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = [
        'assets_id' => $row['assets_id'],
        'assets' => $row['assets'],
        'brand' => $row['brand'],
        'model' => $row['model'],
        'sn' => $row['sn'],
        'cname_id' => $row['cname_id'] ? $row['cname_id'] : '',
        'cname' => $row['cname'] ? $row['cname'] : 'Available Part',
        'allocated' => $row['allocated'] ? true : false, // Set allocated flag
    ];
}

// Count total rows for pagination
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM assets WHERE sn LIKE '$name%'");
$totalRows = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRows / $limit);

// Return data with pagination info
echo json_encode(['data' => $data, 'totalPages' => $totalPages]);
?>