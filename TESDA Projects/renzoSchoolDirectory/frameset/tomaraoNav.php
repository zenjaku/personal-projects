<?php
include '../server/tomaraoConnection.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Navigation Bar</title>
</head>

<body>
    <nav>
        <ul>
            <?php
            if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
                if (isset($_SESSION['type']) && (int) $_SESSION['type'] === 1) {
                    ?>
                    <li>
                        <a href="../views/tomaraoDashboard.php" target="mid">
                            <button type="button" class="renzo-primary-btn">Admin Dashboard</button>
                        </a>
                    </li>
                    <li>
                        <form method="post" action="../server/tomaraoMethod.php">
                            <button type="submit" name="logout" class="logout-btn">Logout</button>
                        </form>
                    </li>
                    <?php
                } else {
                    ?>
                    <li>
                        <a href="../views/tomaraoDashboard.php" target="mid">
                            <button type="button" class="renzo-primary-btn">Dashboard</button>
                        </a>
                    </li>
                    <li>
                        <form method="post" action="../server/tomaraoMethod.php">
                            <button type="submit" name="logout" class="logout-btn">Logout</button>
                        </form>
                    </li>
                    <?php
                }
            } else {
                ?>
                <li>
                    <a href="../views/tomaraoLoginRegister.php" target="mid">
                        <button type="button" class="renzo-primary-btn">Login</button>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>

</body>

</html>