<?php
include_once 'connections.php';
session_start();

if (isset($_POST['allocate'])) {
    // Validate and sanitize inputs
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $assets_id = htmlspecialchars(trim($_POST['assets_id']));
    $assets = htmlspecialchars(trim($_POST['c_assets']));
    $sn = htmlspecialchars(trim($_POST['sn']));
    $status = 1; // Make sure status is defined here

    $checkStatus = mysqli_query($conn, "SELECT * FROM allocation WHERE assets_id = '$assets_id'");

    // If allocation record exists, check its status
    $statusQ = mysqli_fetch_assoc($checkStatus);

    if ($statusQ) { // If an allocation record is found
        $employeeDataId = $statusQ['employee_id'];
        $getEmployeeData = mysqli_query($conn, "SELECT * FROM employee WHERE employee_id = '$employeeDataId'");
        $employeeData = mysqli_fetch_assoc($getEmployeeData);

        if (!$employeeData) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Employee data not found.';
            echo "<script> window.location = '/index.php?page=allocate'; </script>";
            exit();
        }

        $employeeName = $employeeData['fname'] . ' ' . $employeeData['lname'];

        // Check if asset is already allocated (status 1)
        if ((int) $statusQ["status"] == 1) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Assets is still allocated to ' . $employeeName;
            echo "<script> window.location = '/index.php?page=allocate'; </script>";
            exit();
        }
    }
    // Insert the user data into the database if status check is passed
    $query = "INSERT INTO allocation (employee_id, assets_id, assets, sn, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $employee_id, $assets_id, $assets, $sn, $status);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Information saved successfully';
        $t_employee_id = null;

        // Start a loop to ensure the history_id is unique
        do {
            // Generate a new history_id
            $history_id = 'history' . '_' . rand(00000, 99999);

            // Query to check if the generated history_id already exists
            $check_query = "SELECT COUNT(*) FROM assets_history WHERE history_id = ?";
            $stmt = $conn->prepare($check_query);
            $stmt->bind_param("s", $history_id);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            // Continue the loop if the history_id already exists
        } while ($count > 0);

        // Now that we have a unique history_id, insert the data into assets_history
        // Make sure status is passed correctly for the history insert
        $history = "INSERT INTO assets_history (history_id, employee_id, assets_id, assets, sn, t_employee_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $historystmt = $conn->prepare($history);
        $historystmt->bind_param("sssssis", $history_id, $employee_id, $assets_id, $assets, $sn, $t_employee_id, $status); // Ensure status is included here
        $historyresult = $historystmt->execute();

        // Redirect after successful insertion
        echo "<script> window.location = '/index.php?page=allocate'; </script>";
        exit();
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to save information. Please try again.';
        echo "<script> window.location = '/index.php?page=allocate'; </script>";
        exit();
    }
}
?>