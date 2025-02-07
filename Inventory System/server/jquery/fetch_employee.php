<?php
include '../connections.php';

$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 10;  // Number of records per page
$offset = ($page - 1) * $limit;

// Sanitize input for search
$name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';

// Query the database with pagination
$sql = "SELECT * FROM employee WHERE fname LIKE '$name%' OR lname LIKE '$name%' OR employee_id LIKE '$name%' LIMIT $limit OFFSET $offset";
$query = mysqli_query($conn, $sql);

// Fetch the data
$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = [
        'employee_id' => $row['employee_id'],
        'fname' => $row['fname'],
        'lname' => $row['lname'],
        'contact' => $row['contact'],
        'street' => $row['street'],
        'brgy' => $row['brgy'],
        'city' => $row['city'],
        'province' => $row['province'] ? $row['province'] : '',
        'region' => $row['region'],
        'zip' => $row['zip'],
        'status' => $row['status'],
    ];
}

// Count total rows for pagination
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM employee WHERE fname LIKE '$name%' OR lname LIKE '$name%' OR employee_id LIKE '$name%'");
$totalRows = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRows / $limit);

// Return data with pagination info
echo json_encode(['data' => $data, 'totalPages' => $totalPages]);
?>
