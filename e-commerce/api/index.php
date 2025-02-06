<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/fav-ico.svg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <title>Zenrose</title>
    <script defer src="https://kit.fontawesome.com/e81967d7b9.js" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body id="homepage">
    <?php require("components/Navbar.php"); ?>

    <?php
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] === 'success') {
            ?>
            <div class="alert bg-warning alert-dismissible fade show" role="alert" id="alertSuccess">
                <strong><?php echo $_SESSION['success']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function () {
                    const alertTimeOut = document.getElementById('alertSuccess');
                    const alert = new bootstrap.Alert(alertTimeOut);
                    alert.close();

                }, 3000);
            </script>

            <?php
            unset($_SESSION['status']);
        } elseif ($_SESSION['status'] === 'failed') {
            ?>
            <div class="alert bg-danger alert-dismissible fade show" role="alert" id="alertFailed">
                <strong><?php echo $_SESSION['failed']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function () {
                    const alertTimeOut = document.getElementById('alertFailed');
                    const alert = new bootstrap.Alert(alertTimeOut);
                    alert.close();

                }, 3000);
            </script>
            <?php
            unset($_SESSION['status']); // Clear the session variable
        }
    }
    ?>

    <?php
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] === 'inactive') {
            ?>
            <div class="alert bg-warning alert-dismissible fade show" role="alert" id="inactive">
                <strong><?php echo $_SESSION['inactive']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function () {
                    const alertTimeOut = document.getElementById('inactive');
                    const alert = new bootstrap.Alert(alertTimeOut);
                    alert.close();

                }, 3000);
            </script>

            <?php
            unset($_SESSION['status']);
        } elseif ($_SESSION['status'] === 'incorrect') {
            ?>
            <div class="alert text-white bg-danger alert-dismissible fade show" role="alert" id="incorrect">
                <strong><?php echo $_SESSION['incorrect']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function () {
                    const alertTimeOut = document.getElementById('incorrect');
                    const alert = new bootstrap.Alert(alertTimeOut);
                    alert.close();

                }, 3000);
            </script>
            <?php
            unset($_SESSION['status']); // Clear the session variable
        } elseif ($_SESSION['status'] === 'notRegistered') {
            ?>
            <div class="alert bg-danger alert-dismissible fade show" role="alert" id="notRegistered">
                <strong><?php echo $_SESSION['notRegistered']; ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function () {
                    const alertTimeOut = document.getElementById('notRegistered');
                    const alert = new bootstrap.Alert(alertTimeOut);
                    alert.close();

                }, 3000);
            </script>
            <?php
            unset($_SESSION['status']); // Clear the session variable
        }
    }
    ?>

    <div class="container">
        <?php
        // Default to 'home' if no page is set
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';

        // Include the content file based on the $page variable
        switch ($page) {
            case 'collections':
                require("pages/Collections.php");
                break;
            case 'about':
                require("pages/About.php");
                break;
            case 'contact':
                require("pages/Contact.php");
                break;
            case 'cart':
                require("pages/Cart.php");
                break;
            case 'admin':
                require("pages/Admin.php");
                break;
            case 'home':
            default:
                require("pages/Home.php");
                break;
        }
        ?>
    </div>


    <?php require("components/Newsletter.php"); ?>
    <?php require("components/Footer.php"); ?>

</body>

</html>