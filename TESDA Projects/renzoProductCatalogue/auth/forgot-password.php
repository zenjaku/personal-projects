<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Forgot Password</title>
</head>
<body id="forgot-password">
<?php    
session_start();
if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] === 'failed') {
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
    <div class="renzo-forgot-password-container">
    <h2>Forgot Password ?</h2>
        <div class="renzo-form-container">
            <form action="../server/check-email.php" method="POST" id="forgotPassword" autocomplete="off">
                <label for="email">Email Address</label>
                <input type="email" class="renzo-input-form" name="email" id="email" placeholder="Your registered email address here.">
                <button type="submit" name="check-email" class="renzo-primary-btn">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>