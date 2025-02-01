<?php
include '../connections.php';

// Get the parts already added to the computer (e.g., from the 'computer' table)
$addedPartsQuery = "SELECT assets_id FROM computer";
$addedPartsResult = mysqli_query($conn, $addedPartsQuery);
$addedParts = [];
while ($row = mysqli_fetch_assoc($addedPartsResult)) {
    $addedParts[] = $row['assets_id'];
}

$availablePartsQuery = "SELECT assets_id FROM assets";
$availablePartsResult = mysqli_query($conn, $availablePartsQuery);
$availableParts = [];
while ($row = mysqli_fetch_assoc($availablePartsResult)) {
    $availableParts[] = $row['assets_id'];
}

// $parts = $availableParts ? $addedParts : [];
// $partsIds = !empty($parts) ? implode(',', $parts) : '';

// $getAssetsId = "SELECT assets_id FROM assets WHERE assets_id NOT IN ($partsIds)";

// print_r($getAssetsId);
/// Sanitize input
$search = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$exclude = $_POST['exclude'] ?? [];

// Merge the exclude list with the parts already added
$exclude = array_merge($exclude, $addedParts);

// Optionally, you can print the $exclude array for debugging
// print_r($exclude);

// Quote each exclude value to handle strings in the NOT IN clause
$excludeIds = !empty($exclude) ? "'" . implode("','", $exclude) . "'" : '';

// Optional: debugging output
// print_r($excludeIds);

// Start building the query
$sql = "SELECT * FROM assets WHERE assets_id NOT IN ($excludeIds)";  // Ensure "AND" can be appended safely

if (!empty($excludeIds)) {
    $sql .= " AND assets_id NOT IN ($excludeIds)";
}

if (!empty($search)) {
    $sql .= " AND sn LIKE '$search%'";
}

// Execute the query
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    'data' => $data
]);

// Optional: debugging output to see the SQL query being executed
// print_r($sql);
?>