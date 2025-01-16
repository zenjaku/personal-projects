<?php
include_once '../server/connections.php';
// include '../auth/pages-security.php';
include '../server/fetch-profile.php';

$checkCart = "SELECT * FROM cart WHERE username = '$username'";
$result = mysqli_query($connection, $checkCart);
if (mysqli_num_rows($result) == 0) {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Cart is empty';
    echo "<script>parent.location.href = '../index.php';</script>";
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Checkout</title>
</head>
<body id="checkout">
    <div class="renzo-checkout">
        <?php
        $username = $_SESSION['username'];
        $cart = "SELECT c.cartId, c.productId, c.pname, c.price, c.image, p.qty as stock_qty, 
                SUM(c.qty) as qty 
                FROM cart c 
                JOIN product p ON c.productId = p.productId 
                WHERE c.username = '$username'
                GROUP BY c.productId, c.pname, c.price, c.image";
        $result = mysqli_query($connection, $cart);
        while ($cart = mysqli_fetch_assoc($result)) {
            ?>
                <div class="checkout-container">
                    <div class="checkout-img-container">
                        <img src="../assets/products/<?= $cart['image'] ?>" alt="<?= $cart['pname'] ?>" class="checkout-img">
                    </div>
                    <div class="checkout-details">
                        <h2><?= $cart['pname'] ?></h2>
                        <p><strong>Quantity:</strong> <?= (int)$cart['qty'] ?></p>
                        <p><strong>Total Price:</strong> PHP <?= number_format($cart['price'] * $cart['qty'], 2) ?></p>
                    </div>
                </div>
            <?php
        }
        ?>
    </div>

    <div class="renzo-user-container">
        <div class="renzo-user-details">
            <h2>User Details</h2>
            <hr />
            <h2><?= $user['fname']; ?> <?= $user['lname']; ?></h2>
            <p><strong>Email Address: </strong><?= $user['email']; ?></p>
            <p><strong>Username: </strong><?= $user['username']; ?></p>
            <p><strong>Phone Number: </strong><?= $user['number']; ?></p>
            <p><strong>Address: </strong><?= $user['street']; ?> <?= $user['barangay']; ?> <?= $user['municipality']; ?> <?= $user['province']; ?> <?= $user['zipcode']; ?></p> 
        </div>
    </div>
    <div class="renzo-payment-container">
        <?php
        $username = $_SESSION['username'];
        $total_price = 0;
        $cart = "SELECT c.cartId, c.productId, c.pname, c.price, c.image, p.qty as stock_qty, 
                SUM(c.qty) as qty 
                FROM cart c 
                JOIN product p ON c.productId = p.productId 
                WHERE c.username = '$username'
                GROUP BY c.productId, c.pname, c.price, c.image";
        $result = mysqli_query($connection, $cart);
        while ($cart = mysqli_fetch_assoc($result)) {
            $item_total = $cart['price'] * $cart['qty'];
            $total_price += $item_total;
        }
        ?>
        <h2>Payment Method</h2>
        <hr />
        <u><strong>Total Price: PHP <?= number_format($total_price, 2) ?></strong></u>
        <form action="" method="POST" autocomplete="off" id="payment-form">
            <div class="renzo-payment-options">
                <input type="number" name="total_price" id="total_price" value="<?= $total_price ?>" hidden>
                <input type="radio" name="payment_method" id="paypal" value="paypal" required>
                <label for="paypal">Paypal</label>
                <input type="radio" name="payment_method" id="gcash" value="gcash" required>
                <label for="gcash">GCash</label>
                <input type="radio" name="payment_method" id="paymaya" value="paymaya" required>
                <label for="paymaya">PayMaya</label>
            </div>
            <input type="text" class="renzo-input-form" name="transaction_number" placeholder="Input transaction number here" required>
            <button type="submit" class="renzo-primary-btn" name="checkout">Proceed to Checkout</button>
        </form>
    </div>
    <div class="renzo-paypal-code renzo-hidden">
        <div class="renzo-img-qr">
            <img src="../assets/paypal.png" alt="">
        </div>
    </div>
    
    <div class="renzo-gcash-code renzo-hidden">
        <div class="renzo-img-qr">
            <img src="../assets/gcash.jpg" alt="">
        </div>
    </div>
    
    <div class="renzo-paymaya-code renzo-hidden">
        <div class="renzo-img-qr">
            <img src="../assets/paymaya.webp" alt="">
        </div>
    </div>

    <div class="renzo-overlay-modal renzo-hidden"></div>
    <script>
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
        const overlayModal = document.querySelector('.renzo-overlay-modal');
        const paypalModal = document.querySelector('.renzo-paypal-code');
        const gcashModal = document.querySelector('.renzo-gcash-code');
        const paymayaModal = document.querySelector('.renzo-paymaya-code');

        function hideAllModals() {
            paypalModal.classList.add('renzo-hidden');
            gcashModal.classList.add('renzo-hidden');
            paymayaModal.classList.add('renzo-hidden');
            overlayModal.classList.add('renzo-hidden');
        }

        overlayModal.addEventListener('click', hideAllModals);

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                hideAllModals(); 
                
                if (this.value === 'paypal') {
                    overlayModal.classList.remove('renzo-hidden');
                    paypalModal.classList.remove('renzo-hidden');
                } else if (this.value === 'gcash') {
                    overlayModal.classList.remove('renzo-hidden');
                    gcashModal.classList.remove('renzo-hidden');
                } else if (this.value === 'paymaya') {
                    overlayModal.classList.remove('renzo-hidden');
                    paymayaModal.classList.remove('renzo-hidden');
                }
            });
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['checkout'])) {
    $username = $_SESSION['username'];
    $email = $user['email'];
    $name = $user['fname'] . ' ' . $user['lname'];
    $address = $user['street'] . ' ' . $user['barangay'] . ' ' . $user['municipality'] . ' ' . $user['province'] . ' ' . $user['zipcode'];
    $payment_method = $_POST['payment_method'];
    $total_price = $_POST['total_price'];
    $order_at = date('Y-m-d H:i:s');
    $transaction = $_POST['transaction_number'];

    $cartQuery = "SELECT productId, SUM(qty) as qty FROM cart WHERE username = '$username' GROUP BY productId";
    $result = mysqli_query($connection, $cartQuery);
    $products = [];
    $quantities = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row['productId'];
        $quantities[] = $row['qty'];
    }
    $products = implode(',', $products);
    $qty = implode(',', $quantities);

    $orderId = date('YmdHis') . '-' . $username . '-' . $payment_method . '-' . rand(5, 20);

    $insertOrder = "INSERT INTO orders (orderId, username, email, name, address, payment_method, total_price, transaction_number, order_at, productId, qty) 
                    VALUES ('$orderId', '$username', '$email', '$name', '$address', '$payment_method', '$total_price', '$transaction', '$order_at', '$products', '$qty')";
    $result = mysqli_query($connection, $insertOrder);

    if ($result) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Order placed successfully';
        echo "<script>parent.location.href = '../index.php';</script>";
        $deleteCart = "DELETE FROM cart WHERE username = '$username'";
        $result = mysqli_query($connection, $deleteCart);
        return;
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Order failed please try again later';
        echo "<script>window.location.href = '../pages/checkout.php';</script>";
        return;
    }
}
?>
