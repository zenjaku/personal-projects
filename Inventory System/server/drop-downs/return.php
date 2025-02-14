<?php
// Get the selected employee_id from the URL or default to empty
$id = $_GET['employee_id'] ?? '';
$id = mysqli_real_escape_string($conn, $id);

// transfer from
$getAllocations = "
    SELECT e.employee_id, e.fname, e.lname
    FROM employee e
    LEFT JOIN allocation a ON e.employee_id = a.employee_id
    WHERE a.status = 1
    ORDER BY e.employee_id
";


$transferEmployeeIDResult = mysqli_query($conn, $getAllocations);

// Fetch employee IDs for transfer
$employeeID = mysqli_fetch_all($transferEmployeeIDResult, MYSQLI_ASSOC);

// $fetchTransferData = $conn->query("SELECT t_employee_id FROM transferred WHERE status = 1");
// $transferIDs = array_column($fetchTransferData->fetch_all(MYSQLI_ASSOC), 't_employee_id');

// $original = null;
// foreach ($transferIDs as $id) {
//     $original = $id;
// }
?>