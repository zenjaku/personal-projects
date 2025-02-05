<?php
$notFound = '';
$resultNotFound = '';
$rows = [];
$assetsDetails = [];

if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];

    // Fetch computer history and cname using cname_id
    $stmt = $conn->prepare("SELECT ch.*, c.cname, c.assets_id 
                            FROM computer_history ch
                            LEFT JOIN computer c ON ch.cname_id = c.cname_id
                            WHERE ch.employee_id = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $computerAssets = [];
    while ($row = $result->fetch_assoc()) {
        // Determine the asset history status
        if (!empty($row['return_id'])) {
            $row['status_message'] = 'Returned';
        } elseif (!empty($row['transfer_id'])) {
            $row['status_message'] = 'Transferred';
        } elseif (!empty($row['allocation_id'])) {
            $row['status_message'] = 'Allocated';
        } else {
            $row['status_message'] = 'Unknown';
        }

        $rows[] = $row;
        $computerAssets[] = $row['assets_id']; // Collect serialized assets_id
    }

    if (empty($rows)) {
        $resultNotFound = 'No Data Found';
    }

    // Fetch employee details
    $fetchEmployeeStmt = $conn->prepare("SELECT * FROM employee WHERE employee_id = ?");
    $fetchEmployeeStmt->bind_param("s", $employee_id);
    $fetchEmployeeStmt->execute();
    $show = $fetchEmployeeStmt->get_result()->fetch_assoc();

    if (!$show) {
        $notFound = 'Employee Not Found';
    }

    // Process assets_id: unserialize and get asset details
    foreach ($computerAssets as $index => $serializedAssets) {
        if (!empty($serializedAssets)) {
            $assetIds = unserialize($serializedAssets); // Unserialize to get individual asset IDs
            if (is_array($assetIds) && count($assetIds) > 0) {
                // Convert array to a string of placeholders for SQL query
                $placeholders = implode(',', array_fill(0, count($assetIds), '?'));

                // Prepare the query to fetch asset details
                $query = "SELECT * FROM assets WHERE assets_id IN ($placeholders)";
                $stmt = $conn->prepare($query);

                if ($stmt) {
                    $stmt->bind_param(str_repeat('s', count($assetIds)), ...$assetIds);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($asset = $result->fetch_assoc()) {
                        // Include the history status in asset details
                        $asset['status_message'] = $rows[$index]['status_message'];
                        $assetsDetails[] = $asset;
                    }
                }
            }
        }
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
                    <h3 class="font-weight"><?= isset($show) ? htmlspecialchars($show['fname'] . ' ' . $show['lname']) : '' ?></h3>
                    <h3 class="fst-italic fs-5">(<?= isset($employee_id) ? htmlspecialchars($employee_id) : '' ?>)</h3>
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
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultNotFound): ?>
                        <tr class="text-center">
                            <td colspan="6"><?= $resultNotFound ?></td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($assetsDetails as $asset): ?>
                            <tr>
                                <td><?= htmlspecialchars($rows[0]['cname'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($asset['assets']) ?></td>
                                <td><?= htmlspecialchars($asset['brand']) ?></td>
                                <td><?= htmlspecialchars($asset['model']) ?></td>
                                <td><?= htmlspecialchars($asset['sn']) ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($asset['status_message']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
