<?php
include_once '../server/connections.php';
session_start();

if (isset($_POST['check-email'])) {
    $email = $_POST['email'];
    $_SESSION['reset_email'] = $email;
    $checkEmail = "SELECT email FROM users WHERE email = '$email'";
    $checkedEmail = mysqli_query($connection, $checkEmail);

    if (mysqli_num_rows($checkedEmail) > 0) {
        // echo "<script> window.location.href = 'login.php'; </script>";
        // return;
        $randomNumber = mt_rand(100000, 999999);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/styles.css">
            <title>OTP Page</title>
        </head>
        <body id="otp">
            
        <div class="renzo-overlay-modal renzo-hidden"></div>
            <div class="renzo-otp-container">
                <h2>OTP</h2>
                <input type="number" class="renzo-input-form" value="<?= $randomNumber?>" readonly>
                <button type="button" class="renzo-primary-btn" id="submitButton">Submit</button>
            </div>

            <div class="renzo-reset-container renzo-hidden">
                <h2>PASSWORD RESET</h2>
                <div class="renzo-reset-password">
                    <form action="reset-password.php" method="POST" autocomplete="off" id="resetPassword">
                        <input type="password" name="oldPassword" class="renzo-input-form" placeholder="Your current password" required>
                        <input type="password" name="newPassword" class="renzo-input-form" placeholder="New password" required>
                        <input type="password" name="cNewPassword" class="renzo-input-form" placeholder="Confirm your new password" required>
                        <button type="submit" class="renzo-primary-btn" name="update-password">Submit</button>
                    </form>
                    <button type="button" id="closeBtn" class="renzo-delete-btn">Cancel</button>
                </div>
            </div>
            <script>
                const submitButton = document.getElementById('submitButton');
                const overlayReset = document.querySelector('.renzo-overlay-modal');
                const resetModal = document.querySelector('.renzo-reset-container');
                const close = document.getElementById('closeBtn');

                submitButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    overlayReset.classList.remove('renzo-hidden');
                    resetModal.classList.remove('renzo-hidden');
                    resetModal.classList.remove
                    
                });

                close.addEventListener('click', function(e) {
                    overlayReset.classList.add('renzo-hidden');
                    resetModal.classList.add('renzo-hidden');
                });
            </script>
        </body>
        </html>
        <?php
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Email address do not match in the system.';
        echo "<script> window.location.href = '../auth/forgot-password.php'; </script>";
    }
}

?>

