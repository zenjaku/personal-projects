<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
</head>
<body>
    <header class="container-fluid py-2 sticky-top">
    <nav class="navbar navbar-expand-lg py-1 py-lg-0">
        <div class="container px-2">
            <a href="/" class="logo"> Zenrose </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#top-navbar" aria-controls="top-navbar">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </button>
            <div class="offcanvas offcanvas-end" tab-index="-1" id="top-navbar" aria-labelledby="top-navbarLabel">
                <!-- navigation bar content -->
            <button class="navbar-toggler border-0 outline-focus-0 ms-auto my-4 px-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#top-navbar" aria-controls="top-navbar">
                <div class="bar-close"></div>
                <div class="bar-close"></div>
                <div class="bar-close"></div>
            </button>
            <ul class="navbar-nav ms-lg-auto p-3 p-lg-0 gap-4">
                <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                <!-- <a href="index.php?page=home<?= isset($_SESSION['username']) ? '/' . $_SESSION['username'] : '' ?>" class="nav-link">Home</a> -->
                    <a href="index.php?page=home" class="nav-link">Home</a>
                </li>
                <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                    <a href="index.php?page=events" class="nav-link">Events</a>
                </li>
                <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                    <a href="index.php?page=map" class="nav-link">Maps</a>
                </li>
                <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                    <a href="index.php?page=rsvp" class="nav-link">RSVP</a>
                </li>
                <?php
                if (isset($_SESSION['login']) === true && $_SESSION['login']) {
                    if ($_SESSION['type'] = 1) {
                    ?>
                    <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                        <a href="index.php?page=admin" class="nav-link admin ">Admin</a>
                    </li>
                    <li class="nav-item px-3 px-lg-0 py-1 py-lg-4">
                        <a href="index.php?page=logout" class="nav-link logout text-warning">Logout</a>
                    </li>
                    <?php
                    }
                }
                ?>
            </ul>
            </div>
        </div>
    </nav>
    </header>
</body>
</html>