<?php
$resultNotFound = '';
$notFound = '';

if (isset($_GET['cname_id']) && !empty($_GET['cname_id'])) {
    $cname_id = $_GET['cname_id'];

    // Pagination variables
    $limit = 10;
    $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Fetch total count for pagination
    $countStmt = $conn->prepare("SELECT COUNT(*) AS total FROM allocation WHERE cname_id = ?");
    $countStmt->bind_param("s", $cname_id);
    $countStmt->execute();
    $countResult = $countStmt->get_result()->fetch_assoc();
    $totalRecords = $countResult['total'];
    $totalPages = ceil($totalRecords / $limit);

    // Fetch paginated records
    $stmt = $conn->prepare("
        SELECT computer.cname, allocation.employee_id, allocation.created_at, allocation.updated_at,
        allocation.return_id, allocation.transfer_id
        FROM allocation 
        LEFT JOIN computer ON allocation.cname_id = computer.cname_id 
        WHERE computer.cname_id = ?
        GROUP BY allocation.employee_id
        ORDER BY allocation.updated_at DESC
        LIMIT ?, ?
    ");

    $stmt->bind_param("sii", $cname_id, $offset, $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $resultNotFound = 'Data Not Found';
    }
}

?>

<div class="container py-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>History</h3>
            <a href="/inventory">
                <button class="btn btn-danger" id="closeModal">X</button>
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Computer Name</th>
                        <th scope="col">Employee ID</th>
                        <th scope="col">Status</th>
                        <th scope="col">Allocated Date</th>
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
                            $time = $row['updated_at'] ? $row['updated_at'] : $row['created_at'];

                            // Check if return_id or transfer_id has a value
                            $returnStatus = $row['return_id'] ? 'Returned' : '';
                            $transferStatus = $row['transfer_id'] ? 'Transferred' : '';

                            // Fetch employee details
                            $fetchEmployeeStmt = $conn->prepare("SELECT fname, lname, employee_id FROM employee WHERE employee_id = ?");
                            $fetchEmployeeStmt->bind_param("s", $employeeId);
                            $fetchEmployeeStmt->execute();
                            $employee = $fetchEmployeeStmt->get_result()->fetch_assoc();

                            // Initialize $transferredName to avoid undefined variable warning
                            $transferredName = '';

                            // If transfer_id exists, fetch the transferred employee's name
                            if ($row['transfer_id']) {
                                // Step 1: Fetch t_employee_id from the transferred table using transfer_id
                                $fetchTransferStmt = $conn->prepare("SELECT t_employee_id FROM transferred WHERE transfer_id = ?");
                                $fetchTransferStmt->bind_param("s", $row['transfer_id']);
                                $fetchTransferStmt->execute();
                                $transferResult = $fetchTransferStmt->get_result()->fetch_assoc();

                                if ($transferResult) {
                                    $tEmployeeId = $transferResult['t_employee_id'];

                                    // Step 2: Fetch fname and lname from the employee table using t_employee_id
                                    $fetchTransferredEmployeeStmt = $conn->prepare("SELECT fname, lname, employee_id FROM employee WHERE employee_id = ?");
                                    $fetchTransferredEmployeeStmt->bind_param("s", $tEmployeeId);
                                    $fetchTransferredEmployeeStmt->execute();
                                    $transferredEmployee = $fetchTransferredEmployeeStmt->get_result()->fetch_assoc();

                                    if ($transferredEmployee) {
                                        $transferredName = $transferredEmployee['fname'] . ' ' . $transferredEmployee['lname'];
                                        $transferredEmployeeID = $transferredEmployee['employee_id'];
                                        // echo "Debug: Transferred Name = $transferredName"; // Debugging statement
                                    } else {
                                        // echo "Debug: No employee data found for t_employee_id: $tEmployeeId"; // Debugging statement
                                    }
                                } else {
                                    // echo "Debug: No transfer data found for transfer_id: " . $row['transfer_id']; // Debugging statement
                                }
                            }
                            ?>

                            <tr>
                                <td><?= htmlspecialchars($row['cname']) ?></td>
                                <td><?= htmlspecialchars($employee['employee_id'] ?? 'Unknown') ?></td>
                                <td>
                                    <?php
                                    if ($returnStatus) {
                                        echo $returnStatus;  // 'Returned'
                                    } elseif ($transferStatus) {
                                        echo $transferStatus . ' to ' . $transferredName . ' <a href="/view?employee_id=' . $transferredEmployeeID . '"><span class="badge bg-danger">' . $transferredEmployeeID . '</span></a>';
                                    } else {
                                        echo 'Allocated';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?= $time ?>
                                </td>
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
                                <a class="page-link" href="?cname_id=<?= htmlspecialchars($cname_id) ?>&page=1"
                                    title="First">
                                    <span aria-hidden="true">&laquo;&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item <?= ($page == 1) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?cname_id=<?= htmlspecialchars($cname_id) ?>&page=<?= $page - 1 ?>"
                                    title="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                    <a class="page-link"
                                        href="?cname_id=<?= htmlspecialchars($cname_id) ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?cname_id=<?= htmlspecialchars($cname_id) ?>&page=<?= $page + 1 ?>" title="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <li class="page-item <?= ($page == $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link"
                                    href="?cname_id=<?= htmlspecialchars($cname_id) ?>&page=<?= $totalPages ?>"
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