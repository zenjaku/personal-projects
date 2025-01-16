<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Login</title>
</head>
<body id="login-form">
    <section class="renzo-login-container">
        <div class="renzo-login-form">
        <h1>Product Catalogue</h1>
            <form action="../server/login.php" method="POST" id="loginForm">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="renzo-input-form">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="renzo-input-form">
                <button type="submit" name="login" class="renzo-primary-btn">Login</button>
            </form>
            <div class="renzo-forgot-password">
                <a href="forgot-password.php" target="mid">Forgot password?</a>
            </div>
            
<!-- session-status -->
<?php
session_start();
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] === 'success') {
            ?>
            <div class="renzo-alert renzo-bg-warning" id="alertSuccess">
                <strong><?php echo $_SESSION['success']; ?></strong>
                <button type="button" class="renzo-btn-close">X</button>
            </div>
            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alertSuccess');
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 3000);

                const closeButton = document.querySelector('.renzo-btn-close');
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

                const closeButton = document.querySelector('.renzo-btn-close');
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
        </div>
    </section>
    
</body>
</html>