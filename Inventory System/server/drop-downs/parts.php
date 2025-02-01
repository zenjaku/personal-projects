<?php
$selected_assets = $_GET['selected_assets'] ?? [];
$selected_assets = array_map(function($asset) use ($conn) {
    return mysqli_real_escape_string($conn, $asset);
}, $selected_assets);

$assetsQuery = "SELECT DISTINCT assets, brand, model FROM assets";

if (!empty($selected_assets)) {
    $assetsQuery .= " WHERE CONCAT(assets, ' ', brand, ' ', model) NOT IN ('" . implode("','", $selected_assets) . "')";
}

$assetsResult = mysqli_query($conn, $assetsQuery);
?>