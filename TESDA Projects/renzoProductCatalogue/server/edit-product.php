<?php
include_once('connections.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Edit Product</title>
</head>
<body>
    <?php
    $productId = $_GET['productId'];
    $checkProduct = "SELECT * FROM product WHERE productId = '$productId'";
    $result = mysqli_query($connection, $checkProduct);
    $row = mysqli_fetch_assoc($result);
    ?>
    <div class="edit-form-container">
    <h2>Edit Product: <?= $row['pname'] ?></h2>
        <form action="" method="POST" autocomplete="off" id="editForm">
            <input class="input-form" type="text" name="pname" placeholder="<?= $row['pname'] ?>">
            <input class="input-form" type="number" name="price" placeholder="PHP <?= $row['price'] ?>">
            <input class="input-form" type="text" name="unit" placeholder="<?= $row['unit'] ?>">
            <input class="input-form" type="number" name="qty" id="qty" placeholder="<?= $row['qty'] ?>">
            <input class="input-form" type="text" name="description" id="description" placeholder="<?= $row['description'] ?>">
            <!-- <input class="input-form" type="text" name="category" id="category" placeholder="" required> -->
             <select name="category" id="category" class="input-form">
                <option value="" selected disabled><?= $row['category'] ?></option>
                <option value="Vegetables">Vegetables</option>
                <option value="Fruits">Fruits</option>
                <option value="Beverages">Beverages</option>
             </select>
            <img src="../assets/products/<?= $row['image'] ?>" alt="<?= $row['pname'] ?>" class="edit-image">
            <p class="input-text">Change Image?</p>
            <input class="input-form" type="file" name="image" id="image">
            <button type="submit" name="edit" class="primary-btn">Submit</button>
        </form>
        <a href="../admin/products.php">
        <button type="button" class="secondary-btn">Cancel</button>
        </a>
    </div>
    <?php
    ?>
</body>
</html>

<?php
session_start();
if (isset($_POST['edit'])) {
    $pname = !empty($_POST['pname']) ? $_POST['pname'] : $row['pname'];
    $price = !empty($_POST['price']) ? $_POST['price'] : $row['price'];
    $unit = !empty($_POST['unit']) ? $_POST['unit'] : $row['unit'];
    $qty = !empty($_POST['qty']) ? $_POST['qty'] : $row['qty'];
    $description = !empty($_POST['description']) ? $_POST['description'] : $row['description'];
    $category = !empty($_POST['category']) ? $_POST['category'] : $row['category'];
    $image = !empty($_POST['image']) ? $_POST['image'] : $row['image'];
    $updated_at = date('Y-m-d H:i:s');

    $updateProduct = "UPDATE product SET pname = '$pname', price = '$price', unit = '$unit', qty = '$qty', description = '$description', category = '$category', image = '$image', updated_at = '$updated_at' WHERE productId = '$productId'";
    $result = mysqli_query($connection, $updateProduct);

    if ($result) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] =$pname . ' updated successfully.';
        echo "<script>window.location.href = '../admin/products.php';</script>";
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] ='Failed to update '. $pname;
        echo "<script>window.location.href = '../admin/products.php';</script>";
    }
}
?>
