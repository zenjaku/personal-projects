<?php

include_once('tomaraoConnection.php');

if (isset($_POST['btn_order'])) {
    $quantity = $_POST['txt_qty'];
    $total_price = $_POST['txt_price'];
    $date = date('Y-m-d', strtotime('H:i:s'));
    $customer_contact = $_POST['txt_contact'];
    $item_id = $_POST['txt_itemId'];
    $name = $_POST['txt_name'];


    $overallTotal = $total_price * $quantity;

    $save = mysqli_query($tomarao, "INSERT INTO `orders` (`order_id`, `total_price`, `date_time`, `customer_contact`, `item_id`, `name`)
        VALUES ('', '$overallTotal', '$date', '$customer_contact', '$item_id', '$name' ) ");

    if ($save) {
        echo "<script> alert ('Please check your information');
                window.location.href = '../tomaraoOrders.php'; </script>";
    } else {
        echo "<script> alert ('An error occurred');
                window.location.href = '../tomaraoOrders.php'; </script>";
    }
}