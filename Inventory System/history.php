<?php
session_start();
include_once 'server/connections.php';
require_once "server/allocate.php";
include 'admin/auth.php';

$resultNotFound = '';
$notFound = '';

if (isset($_GET['assets_id']) && !empty($_GET['assets_id'])) {
    $assets_id = $_GET['assets_id'];
    // Pagination variables
    $limit = 10;
    $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Fetch total count for pagination
    $countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM assets_history WHERE assets_id = ?");
    $countStmt->bind_param("s", $assets_id);
    $countStmt->execute();
    $countResult = $countStmt->get_result()->fetch_assoc();
    $totalRecords = $countResult['total'];
    $totalPages = ceil($totalRecords / $limit);

    // Fetch paginated records
    $stmt = $conn->prepare("SELECT * FROM assets_history WHERE assets_id = ? ORDER BY updated_at DESC, status ASC LIMIT ? OFFSET ?");
    $stmt->bind_param("sii", $assets_id, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $resultNotFound = 'Data Not Found';
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
    <title>History</title>
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
                <h3>History</h3>
                <a href="index.php?page=inventory">
                    <button class="btn btn-danger" id="closeModal">X</button>
                </a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Assets ID</th>
                            <th scope="col">Employee</th>
                            <th scope="col">Assets</th>
                            <th scope="col">S/N</th>
                            <th scope="col">Status</th>
                            <th scope="col">Transferred To</th>
                            <th scope="col">Action Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultNotFound): ?>
                            <tr>
                                <td colspan="7" class="text-center"><?= $resultNotFound ?></td>
                            </tr>
                        <?php else: ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <?php
                                $employeeId = $row['employee_id'];
                                $t_id = $row['t_employee_id'];
                                if ($row['updated_at']) {
                                    $updated_at = $row['updated_at'];
                                } elseif ($row['updated_at'] == null) {
                                    $created_at = $row['created_at'];
                                }

                                $assetName = $row['assets'];

                                // Fetch employee details
                                $fetchEmployeeStmt = $conn->prepare("SELECT fname, lname, employee_id FROM employee WHERE employee_id = ?");
                                $fetchEmployeeStmt->bind_param("s", $employeeId);
                                $fetchEmployeeStmt->execute();
                                $employee = $fetchEmployeeStmt->get_result()->fetch_assoc();

                                // Fetch transferred employee details if applicable
                                $transferEmployee = null;
                                if ($t_id) {
                                    $fetchTransferStmt = $conn->prepare("SELECT fname, lname FROM employee WHERE employee_id = ?");
                                    $fetchTransferStmt->bind_param("s", $t_id);
                                    $fetchTransferStmt->execute();
                                    $transferEmployee = $fetchTransferStmt->get_result()->fetch_assoc();
                                }
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['assets_id']) ?></td>
                                    <td><?= htmlspecialchars($employee['fname'] ?? 'Unknown') . ' ' . htmlspecialchars($employee['lname'] ?? '') ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['assets']) ?></td>
                                    <td><?= htmlspecialchars($row['sn']) ?></td>
                                    <td>
                                        <?php
                                        $statusText = [
                                            '1' => 'Allocated',
                                            '2' => 'Not Allocated',
                                            '3' => 'Transferred',
                                            '4' => 'Returned',
                                        ];
                                        echo $statusText[$row['status']] ?? 'Unknown';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ((int) $row['status'] === 3 || $row['status'] === 2) {
                                            echo isset($transferEmployee) ? $transferEmployee['fname'] . ' ' . $transferEmployee['lname'] : 'Unknown';
                                        } elseif ((int) $row['status'] === 1) {
                                            if ($employee['employee_id'] == $row['employee_id']) {
                                                ?>
                                                <form action="" method="post" id="transferForm">
                                                    <input type="hidden" name="assets" id="assets" value="<?= $assetName ?>">
                                                    <input type="hidden" name="assets_id" id="assets_id"
                                                        value="<?= $row['assets_id'] ?>">
                                                    <input type="hidden" name="employee_id" id="employee_id"
                                                        value="<?= $row['employee_id'] ?>">
                                                    <input type="hidden" name="sn" id="sn" value="<?= $row['sn'] ?>">
                                                    <div class="d-flex gap-2">
                                                        <select name="t_employee_id" id="t_employee_id" class="form-select w-75"
                                                            required>
                                                            <option value="Employee ID">Employee ID</option>
                                                            <?php while ($emp = mysqli_fetch_assoc($employeeID)): ?>
                                                                <?php
                                                                // Skip the employee if the IDs match
                                                                if ($emp['employee_id'] == $row['employee_id']) {
                                                                    continue;
                                                                }
                                                                ?>
                                                                <option value="<?= htmlspecialchars($emp['employee_id']) ?>"
                                                                    <?= $emp['employee_id'] === $id ? 'selected' : '' ?>>
                                                                    <?= htmlspecialchars($emp['employee_id']) ?>
                                                                </option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                        <button type="submit" name="transfer"
                                                            class="btn btn-dark h-25">Transfer</button>
                                                    </div>
                                                </form>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        } else {
                                            echo 'N/A'; // Show N/A if not transferred
                                        }
                                        ?>
                                    </td>
                                    <td><?= htmlspecialchars($updated_at ? $updated_at : $created_at) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="text-white">
                    <?php if ($resultNotFound): ?>
                        <!-- No data found, don't show pagination -->
                    <?php else: ?>
                        <nav>
                            <ul class="bg-dark rounded p-2 d-flex justify-content-center align-items-center gap-3 border border-2 border-white"
                                id="pagination">
                                <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?assets_id=<?= htmlspecialchars($assets_id) ?>&page=1"
                                        title="First">
                                        <span aria-hidden="true">&laquo;&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?assets_id=<?= htmlspecialchars($assets_id) ?>&page=<?= $page - 1 ?>"
                                        title="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                        <a class="page-link"
                                            href="?assets_id=<?= htmlspecialchars($assets_id) ?>&page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?assets_id=<?= htmlspecialchars($assets_id) ?>&page=<?= $page + 1 ?>"
                                        title="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link"
                                        href="?assets_id=<?= htmlspecialchars($assets_id) ?>&page=<?= $totalPages ?>"
                                        title="Last">
                                        <span aria-hidden="true">&raquo;&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
<?php
if (isset($_POST['transfer'])) {
    $assets_id = $_POST['assets_id'];
    $assets = $_POST['assets'];
    $employeeId = $_POST['employee_id'];
    $t_employee_id = $_POST['t_employee_id'];
    $sn = $_POST['sn'];
    $status = 2;

    // Update allocation status
    $stmt = $conn->prepare("UPDATE allocation SET `status` = ?, `t_employee_id` = ? WHERE sn = ? AND employee_id = ?");
    $stmt->bind_param("isis", $status, $t_employee_id, $sn, $employeeId);

    if ($stmt->execute()) {
        // Update assets history status
        $stmtH = $conn->prepare("UPDATE assets_history SET `status` = ?, `t_employee_id` = ? WHERE sn = ? AND employee_id = ?");
        $stmtH->bind_param("isis", $status, $t_employee_id, $sn, $employeeId);

        if ($stmtH->execute()) {
            $statusA = 1;

            // Insert new allocation record
            $stmtA = $conn->prepare("INSERT INTO allocation (employee_id, assets_id, assets, sn, status) VALUES (?, ?, ?, ?, ?)");
            $stmtA->bind_param("ssssi", $t_employee_id, $assets_id, $assets, $sn, $statusA);

            if ($stmtA->execute()) {
                // Generate a unique history ID
                $uniqueHistoryIDGenerated = false;
                while (!$uniqueHistoryIDGenerated) {
                    $history_id = 'history_' . rand(10000, 99999);
                    $check_query = $conn->prepare("SELECT COUNT(*) FROM assets_history WHERE history_id = ?");
                    $check_query->bind_param("s", $history_id);
                    $check_query->execute();
                    $check_query->bind_result($count);
                    $check_query->fetch();
                    $check_query->close();

                    if ($count == 0) {
                        $uniqueHistoryIDGenerated = true;
                    }
                }

                // Insert into assets history
                $transferId = ''; // Adjusted for logic clarity
                $historyStmt = $conn->prepare("INSERT INTO assets_history (history_id, employee_id, assets_id, assets, sn, t_employee_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $historyStmt->bind_param("sssssis", $history_id, $t_employee_id, $assets_id, $assets, $sn, $transferId, $statusA);

                if ($historyStmt->execute()) {
                    $_SESSION['status'] = 'success';
                    $_SESSION['success'] = 'Transferred successfully';
                    echo "<script> window.location = 'history.php?assets_id=$assets_id'; </script>";
                    exit();
                }
            }
        }
    }

    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Failed to transfer assets. Please try again.';
    echo "<script> window.location = 'history.php?assets_id=$assets_id'; </script>";
    exit();
}
?>