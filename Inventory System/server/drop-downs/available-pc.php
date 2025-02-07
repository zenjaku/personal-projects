<?php
// Retrieve the asset ID from the URL
$asset_id = $_GET['assets_id'] ?? '';

// Validate asset_id
if (empty($asset_id)) {
    die("Invalid asset ID.");
}

// Fetch the asset type (motherboard, cpu, gpu) for the asset_id passed in the URL
$assetTypeQuery = "SELECT assets FROM assets WHERE assets_id = ?";
$stmt = mysqli_prepare($conn, $assetTypeQuery);
mysqli_stmt_bind_param($stmt, "s", $asset_id);
mysqli_stmt_execute($stmt);
$assetTypeResult = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($assetTypeResult) === 0) {
    die("Asset not found.");
}

$assetTypeData = mysqli_fetch_assoc($assetTypeResult);
$assetType = $assetTypeData['assets'] ?? null;

// If the asset is not a motherboard, cpu, or gpu, include all computers
$excludeComputers = in_array($assetType, ['MOTHERBOARD', 'PROCESSOR', 'GPU', 'POWER SUPPLY']);

// Query to fetch available computers
$cnameIdQuery = "SELECT computer.cname, computer.cname_id, computer.assets_id FROM computer ORDER BY computer.cname";
$computerResult = mysqli_query($conn, $cnameIdQuery);

// Initialize availableAssets array
$availableAssets = [];

while ($row = mysqli_fetch_assoc($computerResult)) {
    // Deserialize the assets_id field
    $assets_ids = unserialize($row['assets_id']);

    // Debug: Print the deserialized assets_ids array
    // echo "<pre>Debug - Computer: {$row['cname']}, assets_ids: ";
    // print_r($assets_ids);
    // echo "</pre>";

    // Skip if assets_ids is invalid or empty
    if ($assets_ids === false || empty($assets_ids)) {
        continue;
    }

    // Fetch asset types for all assets_ids in the computer
    $assetTypesInComputer = [];
    foreach ($assets_ids as $id) {
        $assetTypeQuery = "SELECT assets FROM assets WHERE assets_id = ?";
        $stmt = mysqli_prepare($conn, $assetTypeQuery);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $assetTypeResult = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($assetTypeResult) > 0) {
            $assetTypeData = mysqli_fetch_assoc($assetTypeResult);
            $assetTypesInComputer[] = $assetTypeData['assets'];
        }
    }

    // Debug: Print the asset types in the computer
    // echo "<pre>Debug - Computer: {$row['cname']}, asset types: ";
    // print_r($assetTypesInComputer);
    // echo "</pre>";

    // Exclude computers that already have an asset of the same type installed
    if ($excludeComputers && in_array($assetType, $assetTypesInComputer)) {
        // echo "<pre>Debug - Excluding Computer: {$row['cname']} (Already has asset type: $assetType)</pre>";
        continue;
    }

    // Add the computer to availableAssets
    $availableAssets[] = $row;
}

// Debugging output to check the available assets
// echo "<pre>Available Computers: ";
// print_r($availableAssets);
// echo "</pre>";
?>