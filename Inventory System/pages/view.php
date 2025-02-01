<?php
$notFound = '';
$resultNotFound = '';
$rows = [];

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT assets_history.*, assets.cname, assets.assets, assets.sn, assets.brand, assets.model 
                            FROM assets_history 
                            JOIN assets ON assets_history.cname_id = assets.cname_id 
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
            <a href="/employee">
                <button class="btn btn-danger" id="closeModal">X</button>
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Computer Name</th>
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
                                <td><?= $row['cname'] ?></td>
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
