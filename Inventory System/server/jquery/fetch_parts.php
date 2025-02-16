<?php
include '../connections.php';

// Get the parts already added to the computer (unserializing assets_id)
$addedPartsQuery = "SELECT assets_id FROM computer";
$addedPartsResult = mysqli_query($conn, $addedPartsQuery);
$addedParts = [];

while ($row = mysqli_fetch_assoc($addedPartsResult)) {
    $unserialized = unserialize($row['assets_id']); // Unserialize the stored assets_id
    if (is_array($unserialized)) {
        $addedParts = array_merge($addedParts, $unserialized); // Merge all asset IDs
    }
}

// Fetch all available parts
$availablePartsQuery = "SELECT assets_id FROM assets";
$availablePartsResult = mysqli_query($conn, $availablePartsQuery);
$availableParts = [];

while ($row = mysqli_fetch_assoc($availablePartsResult)) {
    $availableParts[] = $row['assets_id'];
}

// Get search input
$search = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
$exclude = $_POST['exclude'] ?? [];

// Merge excluded items with already added parts
$exclude = array_merge($exclude, $addedParts);

// Ensure IDs are properly quoted for SQL
$excludeIds = !empty($exclude) ? "'" . implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($exclude), $conn), $exclude)) . "'" : null;

// Pagination variables
$limit = 10;  // Number of items per page
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;  // Current page (default is 1)
$offset = ($page - 1) * $limit;  // Calculate the offset

// Start query
$sql = "SELECT * FROM assets";
$conditions = [];

if (!empty($excludeIds)) {
    $conditions[] = "assets_id NOT IN ($excludeIds)";
}

if (!empty($search)) {
    $conditions[] = "sn LIKE '$search%'";
}

// Append conditions if any exist
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// Get total count of assets for pagination
$totalCountQuery = "SELECT COUNT(*) AS total FROM assets";
$totalCountResult = mysqli_query($conn, $totalCountQuery);
$totalRows = mysqli_fetch_assoc($totalCountResult)['total'];
$totalPages = ceil($totalRows / $limit);  // Total number of pages

// Apply limit and offset to get paginated results
$sql .= " ORDER BY assets_id ASC LIMIT $limit OFFSET $offset";

// Execute query
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Return paginated results along with total pages
echo json_encode([
    'data' => $data,
    'totalPages' => $totalPages
]);

// Debugging output
// print_r($data);
?>
