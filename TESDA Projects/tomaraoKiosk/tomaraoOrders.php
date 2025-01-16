<?php
include_once('php/tomaraoConnection.php');
$search = mysqli_query($tomarao, "SELECT * FROM `orders` ORDER by `order_id` DESC");

$record = mysqli_fetch_assoc($search);

$order_id1 = $record['order_id'];
$item_id = $record['item_id'];
$item_price = $record['total_price'];
$contact = $record['customer_contact'];
$name = $record['name'];
$search_item = mysqli_query($tomarao, "SELECT * FROM `products` WHERE `product_id` = '$item_id'");
$records2 = mysqli_fetch_assoc($search_item);
$img = 'pictures/' . $records2['image_url'];
$price_unit = $records2['price_per_unit'];
$qty = $item_price / $price_unit;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/tomaraoStyles.css">
    <title>TOMARAO KIOSK</title>
</head>

<body id="orderPage">
    <form action="tomaraoOrders.php" method="POST" id="orderForm" autocomplete="off" class="orders">
        <h1>Your Order</h1>

        <div class="tomaraoProductContainer">
            <div class="tomaraoImgContainer">
                <img src="<?= $img; ?>">
            </div>
            <div class="information-container">
                <label>
                    <h2>QUANTITY</h2>
                </label>
                <input type="text" class="tomaraoText" name="txt_qty" readonly value="<?= $qty; ?>">
                <label>
                    <h2>PRICE</h2>
                </label>
                <input type="text" class="tomaraoText" name="txt_price" readonly value="<?= $item_price; ?>">
                <label>
                    <h2>NAME OF BUYER</h2>
                </label>
                <input type="text" class="tomaraoText" name="txt_name" readonly value="<?= $name; ?>">
                <label>
                    <h2>MOBILE NUMBER</h2>
                </label>
                <input type="text" class="tomaraoText" name="txt_contact" readonly value="<?= $contact; ?>">
                <button type="submit" name="btn_submit" class="tomaraoView">SUBMIT</button>
            </div>
        </div>
    </form>

    <?php
    if (isset($_POST['btn_submit'])) {
        $order_id = $order_id1;
        $product_id = $item_id;
        $quantity = $_POST['txt_qty'];
        $price = $_POST['txt_price'];

        $save = mysqli_query($tomarao, "INSERT INTO `order_items`(`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) 
                    VALUE ('$order_item_id', '$order_id', '$product_id', '$quantity', '$price')");

        if ($save) {
            echo '<script> alert ("You have successfully ordered!");
            parent.location.href = "tomaraoMainPage.php" </script>';

        } else {
            echo '<script> alert ("An error occurred!");
            parent.location.href = "tomaraoMainPage.php" </script>';}
    }
    ?>
</body>

</html>