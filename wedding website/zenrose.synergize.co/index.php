<?php
include_once 'auth/config-prod.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/rsvp.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Zenrose Wedding E-Invites</title>
</head>
<body>
    <!-- Include Navbar and Spinner -->
    <?php
    require 'components/navbar.php';
    require 'components/spinner.php';
    ?>

    <!-- Notification Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Important Notice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                This website is a sample only. However, you may still use it, but it supports only one user at a time.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Understood</button>
                </div>
            </div>
        </div> 
    </div>

    <?php
    // Check if there is a session status to display
    if (isset($_SESSION['status'])) {
        ?>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <?php if ($_SESSION['status'] == 'success'): ?>
            <div class="toast show bg-success" role="alert" aria-live="assertive" aria-atomic="true" id="alertSuccess">
                <div class="toast-body justify-content-between d-flex text-white">
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alertSuccess');
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 3000);
            </script>
            <?php unset($_SESSION['status']); ?>
            <?php elseif ($_SESSION['status'] == 'failed'): ?>
            <div class="toast show bg-danger" role="alert" aria-live="assertive" aria-atomic="true" id="alertFailed">
                <div class="toast-body justify-content-between d-flex text-white">
                    <?= $_SESSION['failed'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alertFailed');
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 3000);
            </script>
            <?php unset($_SESSION['status']); ?>
            <?php endif; ?>
        </div>
        <?php
    }
    ?>

    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    switch ($page) {
        case 'login':
            include 'pages/login.php';
            break;
        case 'events':
            include 'pages/events.php';
            break;
        case 'map':
            include 'pages/map.php';
            break;
        case 'rsvp':
            include 'pages/rsvp.php';
            break;
        case 'rsvp-form':
            include 'pages/rsvp-response.php';
            break;
        case 'admin':
            if (isset($_SESSION['login']) && $_SESSION['login'] === true && $_SESSION['type'] === 1) {
                include 'admin/admin.php';
            } else {
                header('Location: index.php?page=login');
                exit;
            }
            break;
        case 'logout':
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit;
        default:
        case 'home':
            include 'pages/home.php';
            break;
    }
    ?>

    <!-- Include Footer -->
    <?php
    require 'components/footer.php';
    ob_end_flush();
    ?>
    <script src="js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hasSeenNotification = localStorage.getItem('hasSeenNotification');
            if (!hasSeenNotification) {
                const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
                modal.show();
                localStorage.setItem('hasSeenNotification', 'true');
            }
        });
    </script>
</body>
</html>
