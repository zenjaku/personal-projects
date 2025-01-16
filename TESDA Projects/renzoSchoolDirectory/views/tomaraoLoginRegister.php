<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script defer src="../js/script.js"></script>
    <title>Login and Register</title>
</head>

<body>
    <?php
    include '../server/tomaraoConnection.php';
    session_start();
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] === 'success' && isset($_SESSION['success'])) {
            ?>
            <div id="alertSuccess"><?= $_SESSION['success']; ?></div>

            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alertSuccess');
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 3000);
            </script>

            <?php
            unset($_SESSION['success']);
        } elseif (isset($_SESSION['failed'])) {
            ?>
            <div id="alertFailed"><?= $_SESSION['failed']; ?></div>

            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alertFailed');
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 3000);
            </script>

            <?php
            unset($_SESSION['failed']);
        }
        unset($_SESSION['status']);
    }
    ?>
    <section id="login">
        <h1>Login</h1>
        <br>
        <form action="../server/tomaraoMethod.php" method="post" autocomplete="off" id="loginForm">
            <input type="text" name="username" placeholder="Username" class="input-fields">
            <input type="password" name="password" placeholder="Password" class="input-fields">
            <button type="submit" class="renzo-primary-btn" name="login">Sign in</button>
        </form>
        <br>
        <p>Don't have an account, click
            <a href="#" id="registerBtn">here</a>
            to continue.
        </p>
    </section>

    <section id="register">
        <h1>Register</h1>
        <br>
        <form action="../server/tomaraoMethod.php" method="post" autocomplete="off" id="registerForm">
            <input type="text" name="fname" placeholder="First Name" class="input-fields">
            <input type="text" name="lname" placeholder="Last Name" class="input-fields">
            <input type="text" name="username" placeholder="Username" class="input-fields">
            <input type="email" name="email" placeholder="Email Address" class="input-fields">
            <input type="password" name="password" placeholder="Password" class="input-fields">
            <input type="password" name="confirmPassword" placeholder="Confirm Password" class="input-fields">
            <button type="submit" class="renzo-primary-btn" name="register">Sign in</button>
        </form>
        <br>
        <p>Already have an account, click
            <a href="#" id="loginBtn">here</a>
            to continue.
        </p>
    </section>

</body>

</html>