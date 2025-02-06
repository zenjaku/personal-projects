<?php
include_once "server/connections.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/p_1.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/e81967d7b9.js" crossorigin="anonymous"></script>
    <title>DILG Monitoring System</title>
</head>

<body>
    <?php if (isset($_SESSION['status'])): ?>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast show bg-<?= $_SESSION['status'] === 'success' ? 'success' : 'danger' ?>" role="alert"
                id="alertMessage">
                <div class="toast-body justify-content-between d-flex text-white">
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

    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle_btn">
                    <img src="assets/p_1.png" class="img-fluid dilg_logo">
                </button>
                <div class="sidebar_logo"><a href="index.php?page=home">DILG</a></div>
            </div>
            <ul class="sidebar_nav d-flex flex-column gap-3">
                <li class="sidebar_item">
                    <a href="index.php?page=home" class="sidebar_link" title="Profile">
                        <i class="fa-solid fa-database"></i>
                        <span>Report</span>
                    </a>
                </li>
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                    <li class="sidebar_item"><a href="index.php?page=register" class="sidebar_link">
                            <i class="fa-solid fa-users"></i>
                            <span>Register</span></a>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="sidebar_footer d-flex flex-column gap-2">
                <li class="sidebar_item">
                    <a href="index.php?page=login" class="sidebar_link" title="Profile">
                        <i class="fa-solid fa-user-lock"></i>
                        <span>Login</span>
                    </a>
                </li>
                <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                    <a href="index.php?page=logout" class="sidebar_link"><i
                            class="fa-solid fa-arrow-right-from-bracket arrow"></i><span>Logout</span></a>
                <?php endif; ?>
            </div>
        </aside>

        <div class="main py-5" id="main">
            <div class="d-flex justify-content-between px-5">
                <h1 class="text-uppercase">DILG Monitoring System</h1>
                <div class="d-flex gap-2">
                    <button class="btn btn-dark" popovertarget="statistics">Statistics</button>
                    <button class="btn btn-dark" popovertarget="age">Age Bracket</button>
                </div>
            </div>

            <?php
            $page = $_GET['page'] ?? 'home';
            switch ($page) {
                case 'login':
                    include 'admin/Login.php';
                    break;
                case 'register':
                    include 'pages/Register.php';
                    break;
                case 'reports':
                    include 'pages/Reports.php';
                    break;
                case 'settings':
                    include 'pages/Settings.php';
                    break;
                case 'logout':
                    include 'server/logout.php';
                    break;
                default:
                case 'home':
                    include 'pages/Home.php';
                    break;
            }
            ?>
        </div>
    </div>

    <div id="statistics" class="bg-body-tertiary w-75" popover>
        <div class="container p-3 table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Status</th>
                        <th scope="col">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $statuses = [
                        1 => 'Under Investigation',
                        2 => 'Surrendered',
                        3 => 'Apprehended',
                        4 => 'Escaped',
                        5 => 'Deceased',
                    ];
                    $statusCounts = "SELECT status, COUNT(*) as count FROM data_table GROUP BY status";
                    $result = mysqli_query($conn, $statusCounts);
                    $counts = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $counts[(int) $row['status']] = $row['count'];
                    }
                    foreach ($statuses as $key => $label):
                        ?>
                        <tr>
                            <td><?= $label ?></td>
                            <td><?= $counts[$key] ?? 0 ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="age" class="bg-body-tertiary w-75" popover>
        <div class="container p-3 table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Age Bracket</th>
                        <th scope="col">Status</th>
                        <th scope="col">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $statuses = [
                        1 => 'Under Investigation',
                        2 => 'Surrendered',
                        3 => 'Apprehended',
                        4 => 'Escaped',
                        5 => 'Deceased',
                    ];

                    $ageBrackets = [
                        '0-18' => [0, 18],
                        '19-35' => [19, 35],
                        '36-50' => [36, 50],
                        '51-65' => [51, 65],
                        '66+' => [66, PHP_INT_MAX],
                    ];

                    foreach ($ageBrackets as $bracket => [$minAge, $maxAge]) {
                        foreach ($statuses as $statusKey => $statusLabel) {
                            $query = "SELECT COUNT(*) as count 
                                  FROM data_table 
                                  WHERE age BETWEEN $minAge AND $maxAge 
                                  AND status = $statusKey";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);
                            $count = $row['count'] ?? 0;

                            if ($count > 0) {
                                echo "<tr>
                                    <td>$bracket</td>
                                    <td>$statusLabel</td>
                                    <td>$count</td>
                                  </tr>";
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>