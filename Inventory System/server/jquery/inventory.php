<?php
include '../connections.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $perPage = 10; // Number of items per page
    $offset = ($page - 1) * $perPage;

    // Query the database to select based on cname instead of sn
    $sql = "SELECT * FROM computer WHERE cname LIKE '$name%' OR cname_id LIKE '$name%' GROUP BY cname LIMIT $perPage OFFSET $offset";
    $query = mysqli_query($conn, $sql);

    // Initialize an array to hold the data
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'cname_id' => $row['cname_id'],
            'cname' => $row['cname'],
        ];
    }

    // Get the total number of records for pagination
    $countSql = "SELECT COUNT(DISTINCT cname) AS total FROM computer WHERE cname LIKE '$name%' OR cname_id LIKE '$name%'";
    $countQuery = mysqli_query($conn, $countSql);
    $totalRows = mysqli_fetch_assoc($countQuery)['total'];
    $totalPages = ceil($totalRows / $perPage);

    // If no results are found, handle accordingly
    if (empty($data)) {
        echo json_encode(['message' => 'No assets found']);
    } else {
        echo json_encode([
            'data' => $data,
            'totalPages' => $totalPages
        ]); // Return the data and total pages as JSON
    }
}
?>