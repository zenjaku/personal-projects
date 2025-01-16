<?php
include_once('connections.php');
session_start();

if (isset($_POST['submit'])) {
    $pname = $_POST['pname'];
    $price = $_POST['price'];
    $unit = $_POST['unit'];
    $image = $_POST['image'];
    $qty = $_POST['qty'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $created_at = date('Y-m-d H:i:s');

    $date = date('Ymd');
    $productId = $date .'-'. $pname;

    $checkProduct = "SELECT * FROM product WHERE pname = '$pname'";
    $result = mysqli_query($connection, $checkProduct);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = $pname . ' already exists.';
        echo "<script>window.location.href = '../admin/products.php';</script>";
    }

    $addProduct = "INSERT INTO product (productId, pname, price, unit, image, qty, category, description, created_at) VALUES ('$productId', '$pname', '$price', '$unit', '$image', '$qty', '$category', '$description', '$created_at')";
    $result = mysqli_query($connection, $addProduct);

    if ($result) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = $pname . ' added successfully.';
        echo "<script>window.location.href = '../admin/products.php';</script>";
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to add '. $pname;
        echo "<script>window.location.href = '../admin/products.php';</script>";
    }
}
?>
