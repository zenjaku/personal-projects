<?php
session_start();
include_once 'server/connections.php';
include 'admin/auth.php';

$notFound = '';
$resultNotFound = '';
$rows = [];

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT assets_history.*, assets.assets, assets.sn, assets.brand, assets.model 
                            FROM assets_history 
                            JOIN assets ON assets_history.assets_id = assets.assets_id 
                            WHERE assets_history.employee_id = ?");
    $stmt->bind_param("s", $employee_id); // "s" means string
    $stmt->execute();
    $result = $stmt->get_result();

    // Filter rows where status is 1 or 3
    while ($row = $result->fetch_assoc()) {
        if ((int) $row['status'] === 1 || (int) $row['status'] === 3) {
            $rows[] = $row;
        }
    }

    if (empty($rows)) {
        $resultNotFound = 'No Data Found';
    }

    // Fetch employee details for the current employee
    $fetchEmployeeStmt = $conn->prepare("SELECT * FROM employee WHERE employee_id = ?");
    $fetchEmployeeStmt->bind_param("s", $employee_id);
    $fetchEmployeeStmt->execute();
    $show = $fetchEmployeeStmt->get_result()->fetch_assoc();

    if (!$show) {
        $notFound = 'Employee Not Found';
    }
}
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
    <title>Employee Assets</title>
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
            <div class="toast show bg-<?= $_SESSION['status'] === 'success' ? 'warning' : 'danger' ?>" role="alert"
                id="alertMessage">
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

    <div class="container py-5">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-center align-items-center gap-4 text-center">
                    <?php if ($notFound): ?>
                        <h2 class="text-center"><?= $notFound ?></h2>
                    <?php else: ?>
                        <h2>Current Assets of</h2>
                        <h3><?= isset($show) ? $show['fname'] . ' ' . $show['lname'] : '' ?></h3>
                        <h3 class="fst-italic fs-5">(<?= isset($employee_id) ? $employee_id : '' ?>)</h3>
                    <?php endif; ?>
                </div>
                <a href="index.php?page=employee">
                    <button class="btn btn-danger" id="closeModal">X</button>
                </a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Assets ID</th>
                            <th scope="col">Assets</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Model</th>
                            <th scope="col">S/N</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultNotFound): ?>
                            <tr class="text-center">
                                <td colspan="5"><?= $resultNotFound ?></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($rows as $row): ?>
                                <tr>
                                    <td><?= $row['assets_id'] ?></td>
                                    <td><?= $row['assets'] ?></td>
                                    <td><?= $row['brand'] ?></td>
                                    <td><?= $row['model'] ?></td>
                                    <td><?= $row['sn'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>