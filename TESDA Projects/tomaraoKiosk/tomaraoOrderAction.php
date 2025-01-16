<?php

include_once('php/tomaraoConnection.php');

$product_id = $_GET['product_id'];
$search = mysqli_query($tomarao, "SELECT * FROM `products` WHERE `product_id` = '$product_id'");

$record = mysqli_fetch_assoc($search);
$product_name = $record['name'];
$price = $record['price_per_unit'];
$img = $record['image_url'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/tomaraoStyles.css">
    <title>TOMARAO KIOSK</title>
</head>

<body id="order">
    <form class="orders" id="orderForm" action="php/tomaraoOrdersNowAction.php" method="POST" autocomplete="off">
        <h1>Order Information</h1><br>
        <div class="tomaraoProductContainer">
            <div class="tomaraoImgContainer">
                <img src="pictures/<?= '' . $img; ?>" alt="<?= '' . $product_name; ?>">
            </div>
            <div class="information-container">
                <h2>
                    <label for="name" name="name"><?= '' . $product_name; ?></label>
                </h2>
                <input type="text" class="tomaraoText" name="txt_price" value="<?= '' . $price; ?>" readonly>
                <input type="text" class="tomaraoText" name="txt_name" placeholder="Enter name" required>
                <input type="number" class="tomaraoText" name="txt_qty" placeholder="Enter quantity" required>
                <input type="number" class="tomaraoText" name="txt_contact" placeholder="Enter mobile number" required>
                <input type="hidden" class="tomaraoText" name="txt_itemId" value="<?= $product_id; ?>">

                <div>
                    <button type="submit" name="btn_order" class="tomaraoCompute"> ORDER NOW </button>
                </div>

            </div>
        </div>
    </form>

</body>

</html>