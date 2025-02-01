<?php
if (isset($_POST['transfer'])) {
    $originalEmployee = $_POST['employee_id'];
    $transferEmployeeID = $_POST['transfer_employee_id'];

    $created_at = date('Y-m-d H:i:s');

    $status = 2;

    // Fixed SQL Query to fetch the data of the original employee
    $getData = $conn->query("
        SELECT allocation.cname_id, computer.cname, employee.fname, employee.lname, employee.employee_id 
        FROM allocation 
        LEFT JOIN computer ON allocation.cname_id = computer.cname_id 
        LEFT JOIN employee ON allocation.employee_id = employee.employee_id 
        WHERE allocation.employee_id = '$originalEmployee'
    ");

    $data = $getData->fetch_assoc();

    if ($data) {
        $cname_id = $data["cname_id"];
        $cname = $data['cname'];
        $transferName = ($transferEmployeeID == $data['employee_id']) ? ($data["fname"] . ' ' . $data['lname']) : '';

        // Insert data into the transferred table
        $insertTransfer = $conn->prepare("INSERT INTO transferred (employee_id, t_employee_id, cname_id, created_at) VALUES (?, ?, ?, ?)");
        $insertTransfer->bind_param("ssss", $originalEmployee, $transferEmployeeID, $cname_id, $created_at);
        $insertTransfer->execute();

        if ($insertTransfer->affected_rows > 0) {  // Check if insert was successful
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = $cname . ' is successfully transferred to ' . $transferName;

            // Get the transfer ID for the newly inserted record
            $getTransferID = $conn->query("SELECT transfer_id, cname_id FROM transferred WHERE t_employee_id = '$transferEmployeeID'");
            $transfer = $getTransferID->fetch_assoc();

            $transferID = $transfer['transfer_id'];
            // $transferredCname = $transfer['cname_id'];

            // Update allocation table (for the original employee)
            $updated_at = date('Y-m-d H:i:s');
            $updateAllocation = $conn->prepare("UPDATE allocation SET `transfer_id` = ?, `status` = ? ,`updated_at` = ? WHERE employee_id = ?");
            $updateAllocation->bind_param("iiss", $transferID, $status, $updated_at, $originalEmployee);
            $updateAllocation->execute();

            $allocationStatus = 1;

            // Insert the new allocation record for the transfer employee
            $insertToAllocation = $conn->prepare("INSERT INTO allocation (cname_id, employee_id, status, created_at) VALUES (?, ?, ?, ?)");
            $insertToAllocation->bind_param("ssis", $cname_id, $transferEmployeeID, $allocationStatus, $created_at);
            $insertToAllocation->execute();
        } else {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Cannot transfer ' . $cname . ' to ' . $transferName . '. Please try again later';
        }
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Employee data not found.';
    }

    echo "<script> window.location = '/allocate'; </script>";
    exit();
}
?>