<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Login</title>
</head>
<body id="register-form">
    
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
    <section class="renzo-register-container">
        <div class="renzo-register-form">
        <h1>Product Catalogue</h1>
            <form action="../server/registration.php" method="POST" id="registerForm">
                <input type="text" name="fname" id="fname" class="renzo-input-form" placeholder="First Name" required>
                <input type="text" name="lname" id="lname" class="renzo-input-form" placeholder="Last Name" required>
                <input type="email" name="email" id="email" class="renzo-input-form" placeholder="email@gmail.com" required>
                <input type="text" name="username" id="username" class="renzo-input-form" placeholder="Username" required>
                <input type="password" name="password" id="password" class="renzo-input-form" placeholder="Password" required>
                <input type="password" name="cPassword" id="cPassword" class="renzo-input-form" placeholder="Confirm Password" required>
                <input type="tel" name="number" id="number" class="renzo-input-form" placeholder="09170000123" required pattern="[0-9]{11}" maxlength="11"oninput="this.value = this.value.replace(/[^0-9]/g, '')"onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                <input type="text" name="street" id="street" class="renzo-input-form" placeholder="Street No." required>
                <input type="text" name="barangay" id="barangay" class="renzo-input-form" placeholder="Barangay" required>
                <input type="text" name="municipality" id="municipality" class="renzo-input-form" placeholder="Municipality/City" required>
                <input type="text" name="province" id="province" class="renzo-input-form" placeholder="Province" required>
                <input type="number" name="zipcode" id="zipcode" class="renzo-input-form" placeholder="Zip Code" required minlength="4" maxlength="5" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                <button type="submit" class="renzo-primary-btn" name="register">Register</button>
            </form>
            <div class="renzo-login-back">
                <a href="login.php">Already have an account?</a>
            </div>
        </div>
    </section>
    <script src="../js/scripts.js"></script>
</body>
</html>