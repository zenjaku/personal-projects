<?php
include_once '../server/connections.php';
session_start();

$productId = $_GET['productId'];

$fetchProduct = "SELECT * FROM product WHERE productId = '$productId'";
$result = mysqli_query($connection, $fetchProduct);
$product = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Order Page</title>
</head>
<body id="order">
    
<?php
if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] === 'success') {
        ?>
        <div class="alert bg-warning" id="alertSuccess">
            <strong><?php echo $_SESSION['success']; ?></strong>
            <button type="button" class="btn-close">X</button>
        </div>
        <script>
            setTimeout(function () {
                const alertElement = document.getElementById('alertSuccess');
                if (alertElement) {
                    alertElement.remove();
                }
            }, 3000);

            const closeButton = document.querySelector('.btn-close');
            if (closeButton) {
                closeButton.addEventListener('click', function () {
                    const alertElement = document.getElementById('alertSuccess');
                    if (alertElement) {
                        alertElement.remove();
                    }
                });
            }
        </script>
        <?php
        unset($_SESSION['status']);
    } elseif ($_SESSION['status'] === 'failed') {
        ?>
        <div class="alert bg-danger" id="alertFailed">
            <strong><?php echo $_SESSION['failed']; ?></strong>
            <button type="button" class="btn-close">X</button>
        </div>
        <script>
            setTimeout(function () {
                const alertElement = document.getElementById('alertFailed');
                if (alertElement) {
                    alertElement.remove();
                }
            }, 3000);

            const closeButton = document.querySelector('.btn-close');
            if (closeButton) {
                closeButton.addEventListener('click', function () {
                    const alertElement = document.getElementById('alertFailed');
                    if (alertElement) {
                        alertElement.remove();
                    }
                });
            }
        </script>
        <?php
        unset($_SESSION['status']); // Clear the session variable
    }
}
?>
    <div class="renzo-order-container">
    <a href="../components/main.php" target="mid" class="renzo-back-home"> Back to Home</a>
        <div class="renzo-order-img">
            <!-- <img src="../assets/products/<?= $product['image']; ?>" alt="" class="image-large"> -->
            <img src="../assets/products/<?= $product['image']; ?>" alt="" id="order-img">
        </div>
        <div class="renzo-order-details">
            <h1 class="renzo-details-margin"><?= $product['pname']; ?></h1>
            <p class="renzo-details-margin"><?= $product['description']; ?></p>
            <p class="renzo-details-margin"><strong>In stock:</strong> <?= (int) $product['qty']; ?> pcs</p>
            <p class="renzo-details-margin"><strong>Category:</strong> <?= $product['category']; ?></p>
            <p class="renzo-details-margin">PHP <?= $product['price']; ?></p>
            <form action="" method="POST" autocomplete="off">
                <input name="productId" value="<?= $product['productId']; ?>" type="hidden">
                <input name="pname" value="<?= $product['pname']; ?>" type="hidden">
                <input name="price" value="<?= $product['price']; ?>" type="hidden">
                <input name="image" value="<?= $product['image']; ?>" type="hidden">
                <input name="description" value="<?= $product['description']; ?>" type="hidden">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="renzo-primary-btn" name="add-to-cart">Add to Cart</button>
                <!-- <button type="button" class="primary-btn">Buy Now</button> -->
            </form>
        </div>
    </div>
    
    <div class="renzo-review-container">
        <div class="renzo-review">
            <h2 style="font-size: 1.5em; margin-bottom: 1em; text-align: center;">Submit a review</h2>
            <form action="../server/review.php" method="POST" autocomplete="off" id="reviewForm">
                <input type="hidden" name="productId" value="<?= $product['productId']; ?>">
                <div class="input-rating">
                    <input type="radio" name="rating" id="1" value="1" required>
                    <label for="1">⭐</label>
                    <input type="radio" name="rating" id="2" value="2" required>
                    <label for="2">⭐</label>
                    <input type="radio" name="rating" id="3" value="3" required>
                    <label for="3">⭐</label>
                    <input type="radio" name="rating" id="4" value="4" required>
                    <label for="4">⭐</label>
                    <input type="radio" name="rating" id="5" value="5" required>
                    <label for="5">⭐</label>
                </div>
                <textarea type="text" name="review" id="review" class="textarea" placeholder="Write your review here..."></textarea>
                <button type="submit" class="renzo-primary-btn" name="submit-review">Submit</button>
            </form>
        </div>
    </div>

    <div class="review-message">
        <?php
        $productId = $_GET['productId'];
        $message = "SELECT * FROM review WHERE productId = '$productId'";
        $showMessage = mysqli_query($connection, $message);

        if (mysqli_num_rows($showMessage) == 0) {
            echo "<p>No reviews found.</p>";
        } else {
            while ($show = mysqli_fetch_assoc($showMessage)){
                $user = $show['username'];
        ?>
            <div class="message">
                <div class="space-between">
                <?php
                if ($show['rate'] == 1) {
                    ?>
                        <p>⭐</p>
                    <?php
                } elseif ($show['rate'] == 2) {
                    ?>
                        <p>⭐⭐</p>
                        <?php
                } elseif ($show['rate'] == 3) {
                    ?>
                        <p>⭐⭐⭐</p>
                        <?php
                } elseif ($show['rate'] == 4) {
                    ?>
                        <p>⭐⭐⭐⭐</p>
                        <?php
                } elseif ($show['rate'] == 5) {
                    ?>
                        <p>⭐⭐⭐⭐⭐</p>
                    <?php
                }
                ?>
                @<?= $user; ?>
                </div> 
                
                <hr/>
                <h4><?= $show['reviews']; ?></h4>
            </div>
        <?php
            }
        }
        ?>
    </div>

    

    <script>
        const imageLarge = document.getElementById('order-img');
        imageLarge.addEventListener('click', () => {
            imageLarge.classList.toggle('image-large');
        });

        const starRating = document.querySelectorAll('input[name="rating"]');
        starRating.forEach(star => {
            star.addEventListener('click', () => {
                const clickedValue = star.value;
                starRating.forEach(star => {
                    const label = document.querySelector(`label[for="${star.id}"]`);
                    if (star.value <= clickedValue) {
                        star.checked = true;
                        label.classList.add('highlighted');
                    } else {
                        star.checked = false;
                        label.classList.remove('highlighted');
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php
if (isset($_POST['add-to-cart'])) {

    // session_start();
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Please login to continue.';
        echo "<script>window.location.href='../auth/login.php'; </script>";
        return;
    }

    $username = $_SESSION['username'];

    $checkStock = "SELECT qty FROM product WHERE productId = '$productId'";
    $stockResult = mysqli_query($connection, $checkStock);
    $stock = mysqli_fetch_assoc($stockResult);

    if ($stock['qty'] <= 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Sorry, this product is out of stock!';
        echo "<script>parent.location.href='../index.php'; </script>";
        return;
    }

    $productId = $_POST['productId'];
    $pname = $_POST['pname'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $qty = $_POST['qty'];

    $cartId = $pname . '-' . date('YmdHis') . rand(100, 999);
    $order_at = date('Y-m-d H:i:s');

    $insertCart = "INSERT INTO cart (cartId, productId, pname, price, image, description, order_at, qty, username) VALUES ('$cartId', '$productId', '$pname', '$price', '$image', '$description', '$order_at', '$qty', '$username')";
    $result = mysqli_query($connection, $insertCart);

    if (!$result) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'There is no stock left for this product.';
        // echo "<script> alert ('There is no stock left for this product.'); </script>";
        return;
    } else {
        $updateStock = "UPDATE product SET qty = qty - 1 WHERE productId = '$productId'";
        $updateResult = mysqli_query($connection, $updateStock);
        echo "<script> parent.location.href='../index.php' </script>";
        exit();
    }
}

?>