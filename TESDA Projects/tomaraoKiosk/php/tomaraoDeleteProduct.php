<?php

include_once('tomaraoConnection.php');
$product_id = $_GET['product_id'];

$search_product = mysqli_query($tomarao, "SELECT * FROM `products` WHERE `product_id` = '$product_id'");
$row = mysqli_fetch_assoc($search_product);

$name = $row['name'];
$unit = $row['unit'];
$price_per_unit = $row['price_per_unit'];
$image_url = $row['image_url'];

$products = mysqli_query($tomarao, "INSERT INTO `archive` (`name`, `unit`, `price_per_unit`, `image_url`)
            VALUES ('$name', '$unit', '$price_per_unit', '$image_url')");

$delete = mysqli_query($tomarao, "DELETE FROM `products` WHERE `product_id` = '$product_id'");

if ($delete) {
    echo "<script> alert ('Product $name deleted successfully!');
        window.location.href = '../tomaraoAdminProduct.php'; </script>";
} else {
    echo "<script> alert ('Failed to delete the product $name'.);
    window.location.href = '../tomaraoAdminProduct.php'; </script> ";
}
