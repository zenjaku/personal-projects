<?php
// Get the selected employee_id from the URL or default to empty
$id = $_GET['employee_id'] ?? '';
$id = mysqli_real_escape_string($conn, $id);

// Query to fetch employee_ids that are NOT associated with unreturned allocations and exclude those with status 2
$transferEmployeeIDQuery = "
    SELECT employee.employee_id
    FROM employee
    WHERE EXISTS (
        SELECT 1
        FROM allocation
        WHERE allocation.employee_id = employee.employee_id
    )
    AND NOT EXISTS (
        SELECT 1
        FROM allocation
        WHERE allocation.employee_id = employee.employee_id
        AND allocation.status = 2
    )
    ORDER BY employee.employee_id
";


$transferEmployeeIDResult = mysqli_query($conn, $transferEmployeeIDQuery);

// Fetch employee IDs for transfer
$transferEmployeeID = mysqli_fetch_all($transferEmployeeIDResult, MYSQLI_ASSOC);

// Query to fetch employee_ids who do not exist in the allocation table OR exist with status = 1
$transferIDQuery = "
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
        AND allocation.status = 2
    )
    ORDER BY employee.employee_id
";

// Execute the query
$transferIDResult = mysqli_query($conn, $transferIDQuery);

// if (!$transferIDResult) {
//     die("Query failed: " . mysqli_error($conn));
// }

// Fetch employee IDs
// $transferEmployeeID = mysqli_fetch_all($transferIDResult, MYSQLI_ASSOC);

// // Display the results
// echo "<pre>";
// print_r($transferEmployeeID);
// echo "</pre>";
?>