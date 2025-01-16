<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>SMS Message</title>
</head>
<body id="sms">
    <?php
    include_once 'server/connections.php';
    include_once 'server/sms-message.php';

    $date = date('Y-m-d h:i A');
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

        $itemsArray = array();
        
        while ($product = mysqli_fetch_assoc($productResult)) {
            if($orders['delivery_date'] <= date('Y-m-d')){
                $itemsArray[] = $product['pname'];
                $_SESSION['total'] = 'PHP ' . $orders['total_price'];
                $_SESSION['address'] = 'Registered Address: ' . $orders['address'];
            }
        }
        $_SESSION['items'] = $itemsArray;
    }

    $phoneNumber = "SELECT number FROM users WHERE username = '$username'";
    $showQuery = mysqli_query($connection, $phoneNumber);

    if ($result = mysqli_fetch_assoc($showQuery)) {
        $number = $result['number'];
    }
    ;

    if (isset($_SESSION['status_delivery'])) {
        if ($_SESSION['status_delivery'] === 'delivered') {
            ?>
            <div class="renzo-sms-container">
                <div class="renzo-sms-message">
                    <div class="renzo-user-phone-number">
                        <i><?= $date; ?></i>
                        <br/>
                        <br/>
                        <h3>From: Product Catalogue PH</h3>
                        <br/>
                        <p>To: <?= $number; ?></p>
                    </div>
                    <br/>
                    <div class="renzo-user-message">
                        <h2>Hi, <?=$_SESSION['username']?>!</h2> <br/>
                        <br/>
                        <p><?php echo $_SESSION['delivered']; ?></p>
                        <br/>
                        <ul class="renzo-items">Item/s:
                            <?php
                            foreach($_SESSION['items'] as $item) {
                                echo "<li>$item</li>";
                            }
                            ?>
                        </ul>
                        <br>
                        <strong>Total: <?= $_SESSION['total'] ?></strong>
                        
                        <br/>
                        <br/>
                        <p><?= $_SESSION['address'] ?></p>
                    </div>
                </div>
            </div>
            <?php
            unset($_SESSION['status_delivery']);
        }
    } else {
        ?>
        <div class="renzo-sms-container">
                <div class="renzo-sms-message">
                    <div class="renzo-user-phone-number">
                        
                    </div>
                    <br/>
                    <div class="renzo-user-message">
                        <h2 style="text-align: center; margin-bottom: 1em;">No message found.</h2>
                    </div>
                </div>
            </div>
    <?php
    }
    ?>
    
</body>
</html>
