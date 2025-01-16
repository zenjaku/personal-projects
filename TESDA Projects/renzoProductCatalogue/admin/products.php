<?php
include '../auth/auth-security.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Products</title>
</head>
<body id="products">
    
<?php
// session_start();
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
    <div class="renzo-overlay"></div>
    <div class="renzo-product-table">
        <h2>Products</h2>
        <button type="button" class="renzo-primary-btn" id="addProductBtn">Add Products</button>
        <table class="renzo-table">
            <tr>
                <td class="renzo-table-header">Product Id</td>
                <td class="renzo-table-header">Product Name</td>
                <td class="renzo-table-header">Price</td>
                <td class="renzo-table-header">Unit</td>
                <td class="renzo-table-header">Quantity</td>
                <td class="renzo-table-header">Description</td>
                <td class="renzo-table-header">Category</td>
                <td class="renzo-table-header">Image</td>
                <td class="renzo-table-header">Actions</td>
            </tr>

            <?php
            include '../server/fetch-products.php';

            $hasProducts = false;
            while ($row = mysqli_fetch_assoc($result)) {
                $hasProducts = true;
            ?>
            <tr>
                <td class="renzo-table-data"><?php echo $row['productId']; ?></td>
                <td class="renzo-table-data"><?php echo $row['pname']; ?></td>
                <td class="renzo-table-data">PHP <?php echo $row['price']; ?></td>
                <td class="renzo-table-data"><?php echo $row['unit']; ?></td>
                <td class="renzo-table-data"><?php echo $row['qty']; ?> <?php echo $row['unit']; ?></td>
                <td class="renzo-table-data"><?php echo $row['description']; ?></td>
                <td class="renzo-table-data"><?php echo $row['category']; ?></td>
                <td class="renzo-table-data"><img src="../assets/products/<?php echo $row['image']; ?>" alt="product image"></td>
                <td class="renzo-table-data">
                    <a href="../server/edit-product.php?productId=<?php echo $row['productId']; ?>">
                        <button type="button" class="renzo-primary-btn">Edit</button></a>
                    <a href="../server/delete-product.php?productId=<?php echo $row['productId']; ?>">
                        <button type="button" class="renzo-secondary-btn" onclick="return confirm('Are you sure you want to delete <?php echo $row['pname']; ?>?')">Delete</button></a>
                </td>
            </tr>
            <?php
            }
            if(!$hasProducts) {
                ?>
                <tr>
                    <td colspan="9" class="renzo-table-data">
                        <h2>No products found.</h2>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <div class="renzo-product-form-container">
        <h2>Add a Product</h2>
        <form action="../server/add-products.php" method="POST" autocomplete="off" id="productForm">
            <input class="renzo-input-form" type="text" name="pname" placeholder="Product Name" required>
            <input class="renzo-input-form" type="number" name="price" placeholder="Price" required>
            <input class="renzo-input-form" type="text" name="unit" placeholder="Unit" required>
            <input class="renzo-input-form" type="number" name="qty" id="qty" placeholder="Quantity" required>
            <input class="renzo-input-form" type="text" name="description" id="description" placeholder="Description" required>
             <select name="category" id="category" class="renzo-input-form">
                <option value="" selected disabled>--Select Category--</option>
                <option value="Vegetables">Vegetables</option>
                <option value="Fruits">Fruits</option>
                <option value="Beverages">Beverages</option>
             </select>
            <input class="renzo-input-form" type="file" name="image" id="image" required>
            <button type="submit" name="submit" class="renzo-primary-btn">Submit</button>
        </form>
        <a href="../admin/products.php">
        <button type="button" class="renzo-secondary-btn">Cancel</button>
        </a>
    </div>

    <script>
        document.getElementById('addProductBtn').addEventListener('click', function() {
            document.querySelector('.renzo-overlay').style.display = 'block';
            document.querySelector('.renzo-product-form-container').style.display = 'block';
        });

        document.querySelector('.renzo-secondary-btn').addEventListener('click', function() {
            document.querySelector('.renzo-overlay').style.display = 'none';
            document.querySelector('.renzo-product-form-container').style.display = 'none';
        });
    </script>
</body>
</html>
