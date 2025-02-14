<?php
// Get the selected employee_id from the URL or default to empty
$id = $_GET['employee_id'] ?? '';
$id = mysqli_real_escape_string($conn, $id);

// transfer from
$transferEmployeeIDQuery = "
    SELECT e.employee_id, e.fname, e.lname
    FROM employee e
    LEFT JOIN allocation a ON e.employee_id = a.employee_id
    WHERE a.created_at = (
        SELECT MAX(a2.created_at)
        FROM allocation a2
        WHERE a2.employee_id = e.employee_id
    )
    AND a.status = 1
    ORDER BY e.employee_id
";


$transferEmployeeIDResult = mysqli_query($conn, $transferEmployeeIDQuery);

// Fetch employee IDs for transfer
$transferEmployeeID = mysqli_fetch_all($transferEmployeeIDResult, MYSQLI_ASSOC);

// transfer to
$transferIDQuery = "SELECT e.employee_id, e.fname, e.lname
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

// Execute the query
$transferIDResult = mysqli_query($conn, $transferIDQuery);

// if (!$transferIDResult) {
//     die("Query failed: " . mysqli_error($conn));
// }

// Fetch employee IDs
$transfer = mysqli_fetch_all($transferIDResult, MYSQLI_ASSOC);


$fetchTransferData = $conn->query("SELECT t_employee_id FROM transferred WHERE status = 1");
$transferIDs = array_column($fetchTransferData->fetch_all(MYSQLI_ASSOC), 't_employee_id');

$original = null;
foreach ($transferIDs as $id) {
    $original = $id;
}
?>