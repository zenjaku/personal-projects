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
    <title>Cart</title>
</head>
<body id="cart">
    
<!-- session-status -->
<?php
if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] === 'success') {
        ?>
        <div class="renzo-alert renzo-bg-warning" id="alertSuccess">
            <strong><?php echo $_SESSION['success']; ?></strong>
            <button type="button">X</button>
        </div>
        <script>
            setTimeout(function () {
                const alertElement = document.getElementById('alertSuccess');
                if (alertElement) {
                    alertElement.remove();
                }
            }, 3000);
        </script>
        <?php
        unset($_SESSION['status']);
    } elseif ($_SESSION['status'] === 'failed') {
        ?>
        <div class="renzo-alert renzo-bg-danger" id="alertFailed">
            <strong><?php echo $_SESSION['failed']; ?></strong>
            <button type="button" class="renzo-btn-close">X</button>
        </div>
        <script>
            setTimeout(function () {
                const alertElement = document.getElementById('alertFailed');
                if (alertElement) {
                    alertElement.remove();
                }
            }, 3000);
        </script>
        <?php
        unset($_SESSION['status']);
    } 
}
?>
    <!-- <h1>Cart Page</h1> -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qty']) && isset($_POST['cart_id'])) {
        $qty = max(0, $_POST['qty']);
        $cartId = $_POST['cart_id'];
        $username = $_SESSION['username'];

        if ($qty === 0) {
            $getProductQuery = "SELECT productId, qty as current_cart_qty FROM cart WHERE cartId = '$cartId' AND username = '$username'";
            $productResult = mysqli_query($connection, $getProductQuery);
            $cartProduct = mysqli_fetch_assoc($productResult);

            $updateStock = "UPDATE product SET qty = qty + {$cartProduct['current_cart_qty']} WHERE productId = '{$cartProduct['productId']}'";
            mysqli_query($connection, $updateStock);

            $deleteItem = "DELETE FROM cart WHERE cartId = '$cartId' AND username = '$username'";
            mysqli_query($connection, $deleteItem);

            header('Location: cart.php');
            exit();
        }

        $getProductQuery = "SELECT productId, qty as current_cart_qty FROM cart WHERE cartId = '$cartId' AND username = '$username'";
        $productResult = mysqli_query($connection, $getProductQuery);
        $cartProduct = mysqli_fetch_assoc($productResult);
        $productId = $cartProduct['productId'];
        $currentCartQty = $cartProduct['current_cart_qty'];

        $checkStock = "SELECT qty FROM product WHERE productId = '$productId'";
        $stockResult = mysqli_query($connection, $checkStock);
        $stock = mysqli_fetch_assoc($stockResult);

        $qtyDifference = $qty - $currentCartQty;

        if ($stock['qty'] < $qtyDifference) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Not enough stock available.';
            echo "<script>window.location.href='cart.php';</script>";
            // echo "<script>alert('Not enough stock available.'); window.location.href='cart.php';</script>";
            exit();
        }

        $updateStock = "UPDATE product SET qty = qty - $qtyDifference WHERE productId = '$productId'";
        mysqli_query($connection, $updateStock);

        $updateCart = "UPDATE cart SET qty = '$qty' WHERE cartId = '$cartId' AND username = '$username'";
        mysqli_query($connection, $updateCart);

        header('Location: cart.php');
        exit();
    }

    // Display cart items
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
            <!-- echo $row['cartId'] . "<br>"; -->
             <div class="cart-container">
                <div class="cart-img-container">
                    <img src="../assets/products/<?= $cart['image'] ?>" alt="<?= $cart['pname'] ?>" class="cart-img">
                </div>
                <div class="cart-details">
                    <h2><?= $cart['pname'] ?></h2>
                    <p><?= $cart['price'] ?></p>
                </div>
                <div class="total-price">
                    <p>PHP <?= number_format($cart['price'] * $cart['qty'], 2) ?></p>
                </div>
                <form action="" method="POST" autocomplete="off">
                    <input type="number" name="qty" class="cart-qty" value="<?= (int) $cart['qty'] ?>" 
                           onchange="this.form.submit()" min="0">
                    <input type="hidden" name="cart_id" value="<?= $cart['cartId'] ?>">
                </form>
             </div>
        <?php
    }
    ?>

    <button type="submit" name="checkout" class="renzo-primary-btn" style="max-width: 150px; width: 100%;" id="checkoutBtn">Checkout</button>
    
    <div class="renzo-overlay-checkout" style="display: none;"></div>
    
    <div class="renzo-modal-container" style="display: none; padding: 2em; text-align: center;">
        <h2 style="text-align: center; margin-bottom: 1em;">CHECKOUT</h2>
        <?php include 'checkout.php'; ?>
        <button class="renzo-secondary-btn" id="closeCheckout" style="margin-top: 3em; background-color: red;">Close</button>
    </div>

    <script>
        const checkout = document.getElementById('checkoutBtn');
        const overlay = document.querySelector('.renzo-overlay-checkout');
        const modalContainer = document.querySelector('.renzo-modal-container');
        const closeBtn = document.getElementById('closeCheckout');

        checkout.addEventListener('click', function(e) {
            e.preventDefault();
            overlay.style.display = 'block';
            modalContainer.style.display = 'block';
        });

        closeBtn.addEventListener('click', function() {
            overlay.style.display = 'none';
            modalContainer.style.display = 'none';
            window.location.reload();
        });
    </script>
</body>
</html>