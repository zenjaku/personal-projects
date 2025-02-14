<?php
// Get the selected employee_id from the URL or default to empty
$id = $_GET['employee_id'] ?? '';
$id = mysqli_real_escape_string($conn, $id);

// Execute the Allocate PC query
$employeeIDQuery = "
    SELECT e.employee_id, e.fname, e.lname
    FROM employee e
    WHERE 
        (
            (SELECT a.status 
             FROM allocation a
             WHERE a.employee_id = e.employee_id
             ORDER BY a.created_at DESC
             LIMIT 1) = 0
        )
        OR NOT EXISTS (
            SELECT 1 
            FROM allocation a
            WHERE a.employee_id = e.employee_id
        )
    ORDER BY e.employee_id
";

$employeeIDResult = mysqli_query($conn, $employeeIDQuery);

// Fetch employee IDs
$employeeIDs = mysqli_fetch_all($employeeIDResult, MYSQLI_ASSOC);


// Get the selected asset name from the URL or default to empty
$asset_name = $_GET['cname_id'] ?? '';
$assetName = mysqli_real_escape_string($conn, $asset_name);

// Query to fetch distinct asset names (cname) that are NOT associated with unreturned allocations
$assetsQuery = "SELECT status, cname, cname_id FROM computer
                WHERE status = 0
                GROUP BY cname
                ORDER BY cname
                ";

// Execute the query to fetch assets not associated with unreturned allocations
$assetsResult = mysqli_query($conn, $assetsQuery);

// Base query to fetch asset data based on selected asset name, if provided
$assetsSearch = "SELECT * FROM assets WHERE 1";
if (!empty($assetName) && $assetName !== 'Computer Name') {
    $assetsSearch .= " AND cname = '$assetName'"; // Additional filter by asset name if needed
}

// Query to fetch available cname_id from the computer table
$cnameIdQuery = "
    SELECT computer.cname, computer.cname_id, computer.assets_id
    FROM computer
    WHERE NOT EXISTS (
        SELECT 1
        FROM allocation
        WHERE allocation.cname_id = computer.cname_id
    )
    GROUP BY computer.cname_id
    ORDER BY computer.cname
";

$computerResult = mysqli_query($conn, $cnameIdQuery);


// Fetch and display the results
$availableAssets = [];
while ($row = mysqli_fetch_assoc($computerResult)) {
    $availableAssets[] = $row;
}



// // // Output the results (for debugging or display)
// echo "<pre>";
// print_r($assetsSearch);
// echo "</pre>";
// echo "<pre> AVAILABLE EMPLOYEE_IDS ";
// print_r($employeeIDs);
// echo "</pre>";
?>