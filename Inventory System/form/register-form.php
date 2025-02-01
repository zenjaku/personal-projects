<?php
include_once 'server/connections.php';

$regions = [];
$provinces = [];
$cities = [];

$fetchRegion = "SELECT * FROM tblregion ORDER BY region_m ASC";
$searchRegion = mysqli_query($conn, $fetchRegion);
while ($region = mysqli_fetch_assoc($searchRegion)) {
    $regions[] = $region;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['region']) && !isset($_POST['register'])) {
        $region = $_POST['region'];
        $query = "SELECT * FROM tblprovince WHERE region_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $region);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $provinces[] = $row;
        }
    }

    if (isset($_POST['province']) && !isset($_POST['register'])) {
        $province = $_POST['province'];
        $query = "SELECT * FROM tblcitymun WHERE province_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $province);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $cities[] = $row;
        }
    }

    if (isset($_POST['register'])) {
        // Validate and sanitize inputs
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $fname = htmlspecialchars(trim($_POST['fname']));
        $lname = htmlspecialchars(trim($_POST['lname']));
        $contact = htmlspecialchars(trim($_POST['contact']));
        $street = htmlspecialchars(trim($_POST['street']));
        $brgy = htmlspecialchars(trim($_POST['brgy']));
        $zip = htmlspecialchars(trim($_POST['zip']));
        $region = $_POST['region'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $status = $_POST['status'];

        // Fetch the names based on the selected codes
        $query = "SELECT region_m FROM tblregion WHERE region_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $region);
        $stmt->execute();
        $stmt->bind_result($region_name);
        $stmt->fetch();
        $stmt->close();

        $query = "SELECT province_m FROM tblprovince WHERE province_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $province);
        $stmt->execute();
        $stmt->bind_result($province_name);
        $stmt->fetch();
        $stmt->close();

        $query = "SELECT citymun_m FROM tblcitymun WHERE citymun_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $city);
        $stmt->execute();
        $stmt->bind_result($city_name);
        $stmt->fetch();
        $stmt->close();

        $created_at = date('Y-m-d H:i:s'); // Store current date & time

        // Insert the user data into the database
        $query = "INSERT INTO employee (employee_id, fname, lname, contact, street, brgy, zip, region, province, city, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssisssss", $employee_id, $fname, $lname, $contact, $street, $brgy, $zip, $region_name, $province_name, $city_name, $status, $created_at);
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