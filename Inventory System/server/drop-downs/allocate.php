<?php
// Get the selected employee_id from the URL or default to empty
$id = $_GET['employee_id'] ?? '';
$id = mysqli_real_escape_string($conn, $id);

// Execute the Allocate PC query
$employeeIDQuery = "
    SELECT DISTINCT employee.employee_id
    FROM employee
    WHERE NOT EXISTS (
        SELECT 1
        FROM allocation
        WHERE allocation.employee_id = employee.employee_id
    )
    OR EXISTS (
        SELECT 1
        FROM allocation
        WHERE allocation.employee_id = employee.employee_id
        AND (allocation.status = 2 OR allocation.transfer_id IS NOT NULL)
    )
    ORDER BY employee.employee_id
";


$employeeIDResult = mysqli_query($conn, $employeeIDQuery);

// Fetch employee IDs
$employeeIDs = mysqli_fetch_all($employeeIDResult, MYSQLI_ASSOC);


// Get the selected asset name from the URL or default to empty
$asset_name = $_GET['cname_id'] ?? '';
$assetName = mysqli_real_escape_string($conn, $asset_name);

// Query to fetch distinct asset names (cname) that are NOT associated with unreturned allocations
$assetsQuery = "
    SELECT computer.cname, computer.cname_id, computer.assets_id
    FROM computer
    WHERE NOT EXISTS (
        SELECT 1
        FROM allocation
        WHERE allocation.cname_id = computer.cname_id
        AND allocation.return_id IS NULL
    )
    GROUP BY computer.cname
    ORDER BY computer.cname
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
        AND allocation.return_id IS NULL
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
// // echo "<pre>";
// // print_r($availableAssets);
// // echo "</pre>";
// echo "<pre>";
// print_r($employeeIDs);
// echo "</pre>";
?>