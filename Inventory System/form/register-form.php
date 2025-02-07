<?php
include_once 'server/connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        // Validate and sanitize inputs
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $fname = htmlspecialchars(trim($_POST['fname']));
        $lname = htmlspecialchars(trim($_POST['lname']));
        $contact = htmlspecialchars(trim($_POST['contact']));
        $street = htmlspecialchars(trim($_POST['street']));
        $brgy = htmlspecialchars(trim($_POST['brgy']));
        $zip = htmlspecialchars(trim($_POST['zip']));

        // Use null if province is not set (NCR case)
        $region = isset($_POST['region']) ? $_POST['region'] : null;
        $province = isset($_POST['province']) && $_POST['province'] !== "" ? $_POST['province'] : null;
        $city = isset($_POST['city']) ? $_POST['city'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;

        $microtime = microtime(true); // Get current microtime as a float
        $milliseconds = sprintf('%03d', ($microtime - floor($microtime)) * 1000); // Extract milliseconds
        $created_at = date('Y-m-d H:i:s', (int) $microtime) . '.' . $milliseconds;

        // Ensure required fields are not null before inserting into DB
        if (!$region || !$city) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Region and City are required.';
            echo "<script> window.location = '/register'; </script>";
            exit();
        }

        // Insert the user data into the database
        $query = "INSERT INTO employee (employee_id, fname, lname, contact, street, brgy, zip, region, province, city, status, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssssisssss",
            $employee_id,
            $fname,
            $lname,
            $contact,
            $street,
            $brgy,
            $zip,
            $region,
            $province,
            $city,
            $status,
            $created_at
        );
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = 'Information saved successfully';
            echo "<script> window.location = '/register'; </script>";
            exit();
        } else {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Failed to save information. Please try again.';
            echo "<script> window.location = '/register'; </script>";
            exit();
        }
    }
}

?>