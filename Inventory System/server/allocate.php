<?php

//employee_id
$id = $_GET['employee_id'] ?? '';
$id = mysqli_real_escape_string($conn, $id);
$employeeID = mysqli_query($conn, "SELECT DISTINCT employee_id FROM employee ORDER BY employee_id");
$baseQuery = "SELECT * FROM employee WHERE 1";
if (!empty($id) && $id !== 'Employee ID') {
    $baseQuery .= " AND employee_id = '$id'";
}

//assets
$asset_name = $_GET['assets'] ?? '';
$assetName = mysqli_real_escape_string($conn, $asset_name);

// Modified query to select assets column
$assetsQuery = mysqli_query($conn, "SELECT DISTINCT assets FROM assets ORDER BY assets");
$assetsResult = $assetsQuery; // Store query result for use in HTML

$assetsSearch = "SELECT * FROM assets WHERE 1";
if (!empty($assetName) && $assetName !== 'Assets') {
    $assetsSearch .= " AND assets = '$assetName'";
}