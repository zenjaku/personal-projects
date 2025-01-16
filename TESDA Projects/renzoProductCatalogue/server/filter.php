<?php
include '../server/connections.php';

$data = json_decode(file_get_contents('php://input'), true);

$conditions = [];
if ($data['veg']) $conditions[] = "category = 'Vegetables'";
if ($data['fruits']) $conditions[] = "category = 'Fruits'";
if ($data['beverages']) $conditions[] = "category = 'Beverages'";
if (!empty($data['search'])) $conditions[] = "pname LIKE '%" . mysqli_real_escape_string($connection, $data['search']) . "%'";

$query = "SELECT * FROM product";
if ($conditions) $query .= " WHERE " . implode(' OR ', $conditions);

$result = mysqli_query($connection, $query);
if (!$result) {
    echo json_encode(['error' => mysqli_error($connection)]);
    exit;
}

$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

echo json_encode($products);
?>