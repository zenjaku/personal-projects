<?php
include_once 'connections.php';
session_start();
$productId = $_GET['productId'];
$productName = "SELECT * FROM product WHERE productId = '$productId'";
$search = mysqli_query($connection, $productName);
$products = mysqli_fetch_assoc($search);

$pname = $products['pname'];

$deleteProduct = "DELETE FROM product WHERE productId = '$productId'";
$result = mysqli_query($connection, $deleteProduct);

if ($result) {
    $_SESSION['status'] = 'success';
    $_SESSION['success'] = $pname . ' deleted successfully.';
    echo "<script>window.location.href = '../admin/products.php';</script>";
} else {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Failed to delete '. $pname;
    echo "<script>window.location.href = '../admin/products.php';</script>";
}
?>