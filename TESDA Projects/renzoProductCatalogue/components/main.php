<?php
include '../server/connections.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Main Page</title>
</head>
<body id="main">
    
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

    <aside>
        <div class="renzo-filter">
            <h2>FILTER</h2>
            <form action="" method="GET" autocomplete="off">
                <ul class="renzo-sidebar">
                    <li>
                        <input type="checkbox" name="Vegetables" id="veg" value="1" class="renzo-input-form" onchange="this.form.submit()" 
                        <?php if (isset($_GET['Vegetables']) && $_GET['Vegetables'] == '1') echo 'checked'; ?>>
                        <label for="veg"> Vegetables</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Fruits" id="fruits" value="1" class="renzo-input-form" onchange="this.form.submit()" 
                        <?php if (isset($_GET['Fruits']) && $_GET['Fruits'] == '1') echo 'checked'; ?>>
                        <label for="fruits"> Fruits</label>
                    </li>
                    <li>
                        <input type="checkbox" name="Beverages" id="beverages" value="1" class="renzo-input-form" onchange="this.form.submit()" 
                        <?php if (isset($_GET['Beverages']) && $_GET['Beverages'] == '1') echo 'checked'; ?>>
                        <label for="beverages"> Beverages</label>
                    </li>
                    <li id="searchForm">
                        <input type="text" class="renzo-input-form" placeholder="Search an item here." name="searchQuery" 
                        value="<?php echo isset($_GET['searchQuery']) ? htmlspecialchars($_GET['searchQuery']) : ''; ?>">
                        <button type="submit" class="renzo-primary-btn" name="search">Search</button>
                    </li>
                </ul>
            </form>
            <button type="reset" class="renzo-secondary-btn" id="resetBtn" onclick="resetFilter()">Reset</button>
        </div>
    </aside>
    <section class="renzo-main-container">
        <?php

        $filter = [];
        if (isset($_GET['Vegetables']) && $_GET['Vegetables'] == '1') {
            $filter[] = "'Vegetables'";
        }
        if (isset($_GET['Fruits']) && $_GET['Fruits'] == '1') {
            $filter[] = "'Fruits'";
        }
        if (isset($_GET['Beverages']) && $_GET['Beverages'] == '1') {
            $filter[] = "'Beverages'";
        }

        $filterQuery = '';
        if (!empty($filter)) {
            $filterQuery = "WHERE category IN (" . implode(",", $filter) . ")";
        }

        if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
            $searchQuery = mysqli_real_escape_string($connection, $_GET['searchQuery']);
            if (!empty($filterQuery)) {
                $filterQuery .= " AND pname LIKE '%$searchQuery%'";
            } else {
                $filterQuery = "WHERE pname LIKE '%$searchQuery%'";
            }
        }

        $fetchProducts = "SELECT * FROM product $filterQuery";
        $result = mysqli_query($connection, $fetchProducts);
        while ($product = mysqli_fetch_assoc($result)) {
            if ($product['qty'] == 0) {
                continue;
            }
            ?>
                <div class="renzo-product-list">
                    <a href="../pages/order-page.php?productId=<?= $product['productId']; ?>" class="renzo-product-container">
                        <div class="renzo-img-container">
                            <img src="../assets/products/<?= $product['image']; ?>" alt="">
                        </div>
                        <p><?= $product['pname']; ?></p>
                        <div class="renzo-price-container">
                            <p>PHP <?= $product['price']; ?></p>
                        </div>
                    </a>
                </div>
                <?php
        }
        ?>
    </section>
    <script src="../js/scripts.js"></script>
   
</body>
</html>