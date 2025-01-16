<?php
include '../auth/pages-security.php';
include_once '../server/connections.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Transactions</title>
</head>
<body id="transaction">
    <h1>Order History</h1>
    <div class="renzo-transaction-container">
        <?php
        $username = $_SESSION['username'];
        $transactions = "SELECT * FROM orders WHERE username = '$username'";
        $history = mysqli_query($connection, $transactions);

        while ($orders = mysqli_fetch_assoc($history)) {
            $products = explode(',', $orders['productId']);
            $quotedProducts = array_map(function ($id) {
                return "'" . trim($id) . "'";
            }, $products);
            $productsList = implode(',', $quotedProducts);

            $fetchProducts = "SELECT * FROM product WHERE productId IN ($productsList)";
            $productResult = mysqli_query($connection, $fetchProducts);

            while ($product = mysqli_fetch_assoc($productResult)) {
                ?>
                <div class="renzo-transaction-info">
                    <img src="../assets/products/<?= $product['image'] ?>" alt="">
                    <div class="renzo-transaction-details">
                        <h2 class="renzo-margin-bottom"><?= $product['pname'] ?></h2>
                        <p class="renzo-margin-bottom">Price: PHP <?= $orders['total_price'] ?></p>
                        <p class="renzo-margin-bottom">Quantity: <?= $orders['qty'] ?></p> 
                        <p class="renzo-uppercase renzo-payment renzo-margin-bottom"><?= $orders['payment_method'] ?></p> <br/>
                        <p class="renzo-margin-bottom"> <strong> Order Date: </strong><br/><br/><?= $orders['order_at'] ?></p> <br/>
                        <?php
                        if ($orders['fulfilled_at'] == null || $orders['delivery_date'] == null) {
                            ?>
                                <p style="background-color: green; width: 100%; height: 40px; text-align: center; color: white; border-radius: 5px; display: flex; align-items: center; justify-content: center;">Pending</p>
                            <?php
                        } elseif ($orders['delivery_date'] > date('Y-m-d')) {
                            echo '<p class="renzo-fulfilled">To be delivered on: ' . $orders['delivery_date'] . '</p>';
                        } elseif ($orders['delivery_date'] <= date('Y-m-d')) {
                            echo '<p class="renzo-fulfilled">Delivered on: ' . $orders['delivery_date'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</body>

</html>
