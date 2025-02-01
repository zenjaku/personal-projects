<?php
include_once __DIR__ . '/server/connections.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/p_1.png" type="image/x-icon">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/e81967d7b9.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <title>Inventory System</title>
</head>

<body>

    <div class="spinner-overlay d-flex flex-column gap-3" id="global-spinner">
        <div class="spinner"></div>
        <span class="text-white fst-bolder fs-4">
            Loading
        </span>
    </div>
    <?php if (isset($_SESSION['status'])): ?>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <?php
            $bgColor = $_SESSION['status'] === 'success' ? 'warning' : 'danger';
            $textColor = $bgColor === 'danger' ? 'text-white' : ''; // Add text-white only if bg-danger
            ?>
            <div class="toast show bg-<?= $bgColor ?> <?= $textColor ?>" role="alert" id="alertMessage">
                <div class="toast-body justify-content-between d-flex">
                    <?= $_SESSION[$_SESSION['status']] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>

        <script>
            setTimeout(() => document.getElementById('alertMessage').remove(), 3000);
        </script>
        <?php unset($_SESSION['status']); ?>
    <?php endif; ?>

    <div class="d-flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar-toggle">
            <div class="sidebar-logo">
                <a href="/"><img src="assets/p_1.png" class="img-fluid hpl_logo"></a>
            </div>
            <!-- Sidebar Navigation -->
            <ul class="sidebar-nav p-0">
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                    <li class="sidebar-header">
                        Tools & Components
                    </li>
                    <li class="sidebar-item">
                        <a href="/inventory" class="sidebar-link d-flex align-items-center gap-3">
                            <i class="fa-solid fa-chart-simple"></i>
                            <span>Inventory</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/build" class="sidebar-link d-flex align-items-center gap-3">
                            <i class="fa-solid fa-computer"></i>
                            <span>Build PC</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/allocate" class="sidebar-link d-flex align-items-center gap-3">
                            <i class="fa-solid fa-truck"></i>
                            <span>Allocate PC</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/parts" class="sidebar-link d-flex align-items-center gap-3">
                            <i class="fa-solid fa-hard-drive"></i>
                            <span>Parts & Components</span>
                        </a>
                    </li>
                    <li class="sidebar-header">
                        Pages
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed has-dropdown d-flex align-items-center gap-3"
                            data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="true" aria-controls="auth">
                            <i class="fa-solid fa-user-lock"></i>
                            <span>Auth</span>
                        </a>
                        <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item">
                                <a href="/employee" class="sidebar-link px-5">
                                    <span>Employee Data</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="admin/database.php" class="sidebar-link px-5"
                                    onclick="setTimeout(() => { window.location.href = '/inventory'; }, 300);">
                                    <span>Backup Database</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="/register" class="sidebar-link px-5" title="Register">
                                    <span>Register</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <!-- <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Setting</span>
                    </a>
                </li> -->
            </ul>
            <!-- Sidebar Navigation Ends -->
            <div class="sidebar-footer d-flex flex-column gap-2 mb-5">
                <?php if (!isset($_SESSION['login']) || $_SESSION['login'] !== true): ?>
                    <li class="sidebar-item">
                        <a href="/admin-register" class="sidebar-link d-flex align-items-center gap-3" title="Register">
                            <i class="fa-solid fa-user"></i>
                            <span>Register</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/login" class="sidebar-link d-flex align-items-center gap-3" title="Login">
                            <i class="fa-solid fa-user-lock"></i>
                            <span>Login</span>
                        </a>
                    </li>
                <?php endif; ?>
            </div>
            <!-- <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Setting</span>
                </a>
            </div> -->
        </aside>
        <!-- Sidebar Ends -->
        <!-- Main Component -->
        <div class="main" id="main">
            <nav class="navbar navbar-expand d-flex justify-content-between p-1">
                <button class="toggler-btn" type="button">
                    <div class="hamburger">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                </button>
                <div class="d-flex gap-2 align-items-center">
                    <h1 class="text-uppercase my-1">HPL GAME DESIGN INVENTORY SYSTEM</h1>
                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                        <a href="/logout" class=" sidebar-link d-flex align-items-center gap-3" title="Logout">
                            <button class="btn btn-danger power-off"><i class="fa-solid fa-power-off"></i></button>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
            <div class="py-3 px-5">

                <?php
                include 'routes/route.php';
                // $page = $_GET['page'] ?? 'home';
                // switch ($page) {
                //     case 'login':
                //         include 'admin/Login.php';
                //         break;
                //     case 'register':
                //         include 'pages/Register.php';
                //         break;
                //     case 'inventory':
                //         include 'pages/Inventory.php';
                //         break;
                //     case 'allocate':
                //         include 'pages/Allocate.php';
                //         break;
                //     case 'employee':
                //         include 'pages/Employee.php';
                //         break;
                //     case 'add':
                //         include 'pages/Add_assets.php';
                //         break;
                //     case 'db':
                //         include 'admin/database.php';
                //         break;
                //     case 'logout':
                //         include 'server/logout.php';
                //         break;
                //     default:
                //     case 'home':
                //         include 'pages/Inventory.php';
                //         break;
                // }
                ?>
            </div>
        </div>
    </div>
</body>

</html>