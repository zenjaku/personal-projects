<?php
include '../connections.php';

$selected_assets = json_decode($_GET['selected_assets'] ?? '[]', true);
$selected_assets = array_map(function($asset) use ($conn) {
    return mysqli_real_escape_string($conn, $asset);
}, $selected_assets);

$assetsQuery = "SELECT DISTINCT assets, brand, model FROM assets";

if (!empty($selected_assets)) {
    $assetsQuery .= " WHERE CONCAT(assets, ' ', brand, ' ', model) NOT IN ('" . implode("','", $selected_assets) . "')";
}

$assetsResult = mysqli_query($conn, $assetsQuery);

if (mysqli_num_rows($assetsResult) > 0) {
    $options = '<option selected disabled>Select Components</option>';
    while ($row = mysqli_fetch_assoc($assetsResult)) {
        $optionValue = htmlspecialchars($row['assets'] . ' ' . $row['brand'] . ' ' . $row['model']);
        $options .= "<option value='{$optionValue}'>{$optionValue}</option>";
    }
} else {
    $options = '<option selected disabled>No other assets found</option>';
}

echo $options;
?>
