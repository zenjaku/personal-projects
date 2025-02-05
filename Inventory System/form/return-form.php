<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['return'])) {

    if (empty($_POST['employee_id'])) {
        die("Employee ID cannot be empty.");
    }

    $employee_id = $_POST['employee_id'];
    $microtime = microtime(true); // Get current microtime as a float
    $milliseconds = sprintf('%03d', ($microtime - floor($microtime)) * 1000); // Extract milliseconds
    $created_at = date('Y-m-d H:i:s', (int) $microtime) . '.' . $milliseconds;
    $updated_at = $created_at; // Use the same timestamp for consistency

    $getData = $conn->query("SELECT allocation.cname_id, computer.cname, employee.employee_id 
                                    FROM allocation 
                                    LEFT JOIN computer ON allocation.cname_id = computer.cname_id 
                                    LEFT JOIN employee ON allocation.employee_id = employee.employee_id 
                                    WHERE allocation.employee_id = '$employee_id'");

    if ($data = $getData->fetch_assoc()) {
        $cname_id = $data["cname_id"];
        $cname = $data["cname"];

        // Insert into transferred table
        $insertData = $conn->prepare("INSERT INTO returned (cname_id, employee_id, created_at) VALUES (?, ?, ?)");
        if (!$insertData) {
            die("Prepare Error: " . $conn->error);
        }
        $insertData->bind_param("sss", $cname_id, $employee_id, $created_at);


        if ($insertData->execute()) {
            // Fetch employee name
            $getName = $conn->query("SELECT r.employee_id, e.fname, e.lname FROM returned r LEFT JOIN employee e ON e.employee_id = r.employee_id WHERE r.employee_id = '$employee_id'");
            if (!$getName) {
                die("Query Error: " . $conn->error);
            }
            if ($showName = $getName->fetch_assoc()) {
                $returnName = (!empty($showName["fname"]) && !empty($showName["lname"])) ? ($showName["fname"] . ' ' . $showName["lname"]) : 'Unknown';
            }
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = $cname . ' is successfully returned by ' . $returnName;

            // Insert into allocation table
            $allocationStatus = 0;
            $updateAllocation = $conn->prepare("UPDATE allocation SET `status` = ?, `updated_at` = ? WHERE employee_id = ? AND status = 1");
            if (!$updateAllocation) {
                die("Prepare Error: " . $conn->error);
            }
            $updateAllocation->bind_param("iss", $allocationStatus, $updated_at, $employee_id);

            if ($updateAllocation->execute()) {

                // get transfer data
                $fetchTransfer = $conn->query("SELECT * FROM transferred WHERE t_employee_id = '$employee_id'");
                if (!$fetchTransfer) {
                    die("Query Error: " . $conn->error);
                }
                $fetchID = $fetchTransfer->fetch_assoc();
                if ($fetchID && !empty($fetchID['t_employee_id'])) {
                    $getID = $fetchID['t_employee_id'];

                    // update transfer data
                    $transferStatus = 0;
                    $updateTransfer = $conn->prepare("UPDATE transferred SET `status` = ?, `updated_at` = ? WHERE t_employee_id = ? AND status = 1");
                    $updateTransfer->bind_param("iss", $transferStatus, $updated_at, $employee_id);

                    $updateTransfer->execute();

                }

                // fetch return_id from returned table
                $fetchReturnData = $conn->prepare("SELECT * FROM returned WHERE employee_id = ?");
                $fetchReturnData->bind_param("s", $employee_id);
                $fetchReturnData->execute();
                $result = $fetchReturnData->get_result();
                $return_id = $result->fetch_assoc();
                if ($return_id && !empty($return_id["return_id"])) {
                    $returnID = $return_id["return_id"];

                    // insert to computer_history
                    $insertToHistory = $conn->prepare("INSERT INTO computer_history (employee_id, return_id, cname_id, created_at) VALUES (?, ?, ?, ?)");
                    $insertToHistory->bind_param("siss", $employee_id, $returnID, $cname_id, $created_at);
                    if ($insertToHistory->execute()) {
                        $updateComputerStatus = 0;
                        $updateComputer = $conn->prepare("UPDATE computer SET `status` = ?, `updated_at` = ? WHERE cname_id = ?");
                        $updateComputer->bind_param("iss", $updateComputerStatus, $updated_at, $cname_id);
                        if ($updateComputer->execute()) {
                            // Redirect after successful insertion
                            echo "<script> window.location = '/allocate'; </script>";
                            exit();
                        }
                    }
                }
            }
        }

        if (!$updateAllocation->execute()) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Cannot transfer ' . $cname . ' to ' . $returnName . '. Please try again later';
            echo "<script> window.location = '/allocate'; </script>";
            exit();
        }

        echo "<script> window.location = '/allocate'; </script>";
        exit();

    }
}
?>