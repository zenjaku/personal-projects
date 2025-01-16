<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Navbar</title>
</head>
<body id="navbar">
    <nav class="renzo-navbar">
        <ul class="renzo-navbar-brand">
            <?php
            
            include_once('../server/connections.php');
            session_start();

            if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                if ($_SESSION['type'] === '1') {
                    ?>
                    <!-- admin -->
                    <li class="renzo-nav_item"><a href="../admin/products.php" target="mid"><button class="renzo-nav_link renzo-primary-btn">Product Table</button></a></li>
                    <li class="renzo-nav_item"><a href="../admin/clients.php" target="mid"><button class="renzo-nav_link renzo-primary-btn">Clients</button></a></li>
                    <li class="renzo-nav_item"><a href="../admin/profile.php" target="mid"><button class="renzo-nav_link renzo-primary-btn">Profile</button></a></li>
                    <li class="renzo-nav_item"><a href="../admin/report.php" target="mid"><button class="renzo-nav_link renzo-primary-btn">Sales Report</button></a></li>
                    <li class="renzo-nav_item"><a href="../server/logout.php" tar1get="mid"><button class="renzo-nav_link renzo-delete-btn">Logout</button></a></li>
                    <?php
                } elseif ($_SESSION['type'] === '0') {
                    ?>
                    <!-- client -->
                     <?php
                     $username = $_SESSION['username'];
                     $getCartCount = "SELECT COUNT(*) FROM cart WHERE username = '$username'";
                     $result = mysqli_query($connection, $getCartCount);
                     $cartCount = mysqli_fetch_assoc($result);
                     $cartCount = $cartCount['COUNT(*)'];
                     ?>
                    <li class="renzo-nav_item"><a href="../pages/cart.php" target="mid"><button class="renzo-nav_link renzo-secondary-btn">Cart <strong>(<?= $cartCount ?>)</strong></button></a></li>
                    <li class="renzo-nav_item"><a href="../pages/profile.php" target="mid"><button class="renzo-nav_link renzo-primary-btn">Profile</button></a></li>
                    <li class="renzo-nav_item"><a href="../pages/transactions.php" target="mid"><button class="renzo-nav_link renzo-primary-btn">Transactions</button></a></li>
                    <li class="renzo-nav_item"><a href="../server/logout.php" target="mid"><button class="renzo-nav_link renzo-primary-btn">Logout</button></a></li>
                    <?php
                }
            } else {
                ?>
                <!-- public -->
                <li class="renzo-nav_item"><a href="../auth/login.php" target="mid"><button class="renzo-nav_link renzo-primary-btn">Login</button></a></li>
                <li class="renzo-nav_item"><a href="../auth/register.php" target="mid"><button class="renzo-nav_link renzo-primary-btn">Register</button></a></li>
                <?php
            }
            ?>
        </ul>
    </nav>
</body>
</html>