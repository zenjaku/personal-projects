<?php
include '../server/connections.php';
include '../auth/auth-security.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Reports</title>
</head>
<body id="report">
    <!-- <h1>Sales Report</h1> -->
    <div class="renzo-overlay-modal renzo-hidden"></div>
    <!-- transaction modal -->
    <button type="button" class="renzo-primary-btn" id="reportBtn" style="width: 10em;">Transactions</button>
    <div class="renzo-report-container renzo-hidden">
        <div class="renzo-closeBtn">
            <button type="button" class="renzo-delete-btn" style="width: 2em;" id="closeBtn">X</button>
        </div>
        <?php
        $transactions = "SELECT * FROM orders";
        $history = mysqli_query($connection, $transactions);

        while ($orders = mysqli_fetch_assoc($history)) {
            $products = explode(',', $orders['productId']);
            $quantities = explode(',', $orders['qty']);
            $quotedProducts = array_map(function ($id) {
                return "'" . trim($id) . "'";
            }, $products);
            $productsList = implode(',', $quotedProducts);

            $fetchProducts = "SELECT * FROM product WHERE productId IN ($productsList)";
            $productResult = mysqli_query($connection, $fetchProducts);

            while ($product = mysqli_fetch_assoc($productResult)) {
                $index = array_search($product['productId'], $products);
                $productQuantity = floatval($quantities[$index]);
                ?>
                <div class="renzo-report-info">
                    <img src="../assets/products/<?= $product['image'] ?>" alt="">
                    <div class="renzo-report-details">
                        <h2 class="renzo-margin-bottom"><?= $orders['name'] ?></h2>
                        <h3 class="renzo-margin-bottom"><?= $product['pname'] ?></h3>
                        <p class="renzo-margin-bottom"><?= $orders['address'] ?></p>
                        <p class="renzo-margin-bottom">Price: PHP <?= $orders['total_price'] ?></p>
                        <p class="renzo-margin-bottom">Quantity: <?= $productQuantity ?></p> 
                        <p class="renzo-uppercase renzo-margin-bottom"><?= $orders['payment_method'] ?></p>
                        <p class="renzo-margin-bottom"> <strong> Order Date:</strong> <?= $orders['order_at'] ?></p>
                        <?php
                        if ($orders['fulfilled_at'] == null || $orders['delivery_date'] == null) {
                            ?>
                                <button type="button" class="renzo-primary-btn" onclick="openModal('modal-<?= $orders['orderId'] ?>')">Fulfilled</button>
                            <?php
                        } elseif ($orders['delivery_date'] > date('Y-m-d')) {
                            echo '<p class="fulfilled">To be delivered on: ' . $orders['delivery_date'] . '</p>';
                        } else {
                            echo '<p class="fulfilled">Delivered on: <br><br>' . $orders['delivery_date'] . '</p>';
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
        <div id="modal-<?= $orders['orderId'] ?>" class="renzo-modal-content renzo-hidden">
            <h2 style="text-align: center; margin-bottom: 1em;">DELIVERY DATE</h2>
            <form action="" method="POST" autocomplete="off">
                <input type="hidden" name="orderId" value="<?= $orders['orderId'] ?>">
                <input type="date" name="delivery_date" class="renzo-input-form" required 
                       min="<?= date('Y-m-d') ?>" 
                       style="width: 100%; font-family: inherit;">
                <button type="submit" name="fulfilled" class="renzo-primary-btn">Confirm Fulfillment</button>
                <button type="button" class="renzo-delete-btn" onclick="closeModal('modal-<?= $orders['orderId'] ?>')">Close</button>
            </form>
        </div>
    <?php
        }
        ?>
    </div>

    <!-- sales-chart -->
    <h1 class="renzo-title" style="text-align: center;">SALES CHART (bestsellers)</h1>
    <div class="renzo-chart-container">
    <?php

    $productSales = [];

    $transactions = "SELECT * FROM orders";
    $history = mysqli_query($connection, $transactions);

    while ($orders = mysqli_fetch_assoc($history)) {
        $products = explode(',', $orders['productId']);
        $quantities = explode(',', $orders['qty']);
        $quotedProducts = array_map(function ($id) {
            return "'" . trim($id) . "'";
        }, $products);
        $productsList = implode(',', $quotedProducts);

        $fetchProducts = "SELECT * FROM product WHERE productId IN ($productsList)";
        $productResult = mysqli_query($connection, $fetchProducts);

        while ($product = mysqli_fetch_assoc($productResult)) {
            $productId = $product['productId'];
            if (!isset($productSales[$productId])) {
                $productSales[$productId] = [
                    'name' => $product['pname'],
                    'order_count' => 0,
                    'image' => $product['image'],
                    'total_qty' => 0
                ];
            }
            $productSales[$productId]['order_count']++;

            $index = array_search($productId, $products);
            if ($index !== false) {
                $productSales[$productId]['total_qty'] += floatval($quantities[$index]);
            }

            $fetchReviews = "SELECT AVG(rate) as average_rate, COUNT(*) as review_count, reviews as message FROM review WHERE productId = '$productId'";
            $rate = mysqli_query($connection, $fetchReviews);
            $rateData = mysqli_fetch_assoc($rate);
            $stars = round($rateData['average_rate'] ?? 0, 1);

            $productSales[$productId]['stars'] = $stars;
            $productSales[$productId]['review_count'] = $rateData['review_count'];

            $productSales[$productId]['message'] = $rateData['message'];
            
        }
    }

    asort($productSales);
    $count = 0;
    foreach ($productSales as $productId => $data) {
        if ($count >= 5) break;
        ?>
        <div class="renzo-chart">
            <div class="renzo-data-container">
                <img src="../assets/products/<?=$data['image']?>" alt="" style="width: 150px;">
                <h3><?= $data['name'] ?></h3>
                <?php
                if ($data['stars'] == 1) {
                    ?>
                        <p>⭐</p>
                    <?php
                } elseif ($data['stars'] == 2) {
                    ?>
                        <p>⭐⭐</p>
                        <?php
                } elseif ($data['stars'] == 3) {
                    ?>
                        <p>⭐⭐⭐</p>
                        <?php
                } elseif ($data['stars'] == 4) {
                    ?>
                        <p>⭐⭐⭐⭐</p>
                        <?php
                } elseif ($data['stars'] == 5) {
                    ?>
                        <p>⭐⭐⭐⭐⭐</p>
                    <?php
                }
                ?>
                <div class="renzo-review">
                    <p>Average Rating: <?= number_format($data['stars'], 1) ?></p>
                    <p>(<?= $data['review_count'] ?> reviews)</p>
                </div>
                <p><?= $data['message']?></p>
                <p class="renzo-footer"><?=$data['total_qty']?> user/s ordered this item.</p>
            </div>
        </div>
        <?php
        $count++;
    }
    ?>
    </div>

    <script>
        //fulfillment modal
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('renzo-hidden');
            document.querySelector('.renzo-overlay-modal').classList.remove('renzo-hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('renzo-hidden');
            document.querySelector('.renzo-overlay-modal').classList.add('renzo-hidden');
        }

        //transaction modal
        const reportBtn = document.getElementById('reportBtn');
        const overlay = document.querySelector('.renzo-overlay-modal');
        const modalContainer = document.querySelector('.renzo-report-container');
        const closeBtn = document.getElementById('closeBtn');

        reportBtn.addEventListener('click', function(e) {
            e.preventDefault();
            overlay.classList.remove('renzo-hidden');
            modalContainer.classList.remove('renzo-hidden');
            modalContainer.classList.remove
            
        });

        closeBtn.addEventListener('click', function(e) {
            overlay.classList.add('renzo-hidden');
            modalContainer.classList.add('renzo-hidden');
        });
    </script>

</body>

</html>
<?php
if (isset($_POST['fulfilled'])) {
    $orderId = $_POST['orderId'];
    $deliveryDate = $_POST['delivery_date'];
    $today = date('Y-m-d');
    
    // Validate that delivery date is not in the past
    if ($deliveryDate <= $today) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Delivery date cannot be in the past or today!';
        echo '<script>window.location.href = "report.php"; </script>';
        return;
    }
    
    $update = date('Y-m-d H:i:s');
    $updateFulfilled = "UPDATE orders SET fulfilled_at = '$update', delivery_date = '$deliveryDate' WHERE orderId = '$orderId'";
    $updateQuery = mysqli_query($connection, $updateFulfilled);
    if ($updateQuery) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Order Fulfilled';
        echo '<script>window.location.href = "report.php"; </script>';
        return;
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Please try again, later.';
        echo '<script>window.location.href = "report.php"; </script>';
        return;
    }
}
?>