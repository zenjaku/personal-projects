<?php
if (isset($_POST['allocate'])) {
    // Validate and sanitize inputs
    $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $cname_id = htmlspecialchars(trim($_POST['cname_id']));
    // $cname = htmlspecialchars(trim($_POST['cname']));

    $status = 1;

    $created_at = date('Y-m-d H:i:s');

    // Check if the allocation record exists
    $checkStatus = mysqli_query($conn, "SELECT * FROM allocation WHERE cname_id = '$cname_id'");
    if (!$checkStatus) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Database query failed. Please try again.';
        echo "<script> window.location = '/allocate'; </script>";
        exit();
    }

    $statusQ = mysqli_fetch_assoc($checkStatus);

    if ($statusQ) {
        $employeeDataId = $statusQ['employee_id'];
        $getEmployeeData = mysqli_query($conn, "SELECT * FROM employee WHERE employee_id = '$employeeDataId'");
        $employeeData = mysqli_fetch_assoc($getEmployeeData);

        if (!$employeeData) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Employee data not found.';
            echo "<script> window.location = '/allocate'; </script>";
            exit();
        }

        $employeeName = $employeeData['fname'] . ' ' . $employeeData['lname'];

        if ((int) $statusQ["status"] == 1) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Asset is still allocated to ' . $employeeName;
            echo "<script> window.location = '/allocate'; </script>";
            exit();
        }
    }

    // Insert new allocation record
    $query = "INSERT INTO allocation (employee_id, cname_id, status, created_at) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssis", $employee_id, $cname_id, $status, $created_at);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Information saved successfully';

        // Redirect after successful insertion
        echo "<script> window.location = '/allocate'; </script>";
        exit();
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to save information. Please try again.';
        echo "<script> window.location = '/allocate'; </script>";
        exit();
    }
}
?>