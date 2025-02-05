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
<style>
    /* Hide everything except the terms-conditions section when printing */
    @media print {
        body * {
            visibility: hidden;
        }

        .not {
            visibility: hidden !important;
            display: none;
        }

        .card-footer {
            visibility: hidden !important;
            display: none;
        }

        #terms-conditions,
        #terms-conditions * {
            visibility: visible;
        }

        #terms-conditions {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20px;
            /* Adjust padding for print */
            box-shadow: none;
            font-size: 12px;
            /* Remove shadows for print */
        }

        /* Optional: Adjust table borders for better print visibility */
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000 !important;
        }

        /* Hide buttons and other unnecessary elements */
        #printBtn,
        #cancelPrint {
            display: none !important;
        }
    }
</style>
<div class="container py-5">
    <div class="card" id="terms-conditions">
        <div class="card-header p-3">
            <div class="d-flex flex-column justify-content-center align-items-center text-center">
                <!-- <?php if ($notFound): ?>
                    <h2 class="text-center"><?= $notFound ?></h2>
                <?php else: ?>
                    <h2>Current Assets of</h2>
                    <h3 class="font-weight"><?= isset($show) ? htmlspecialchars($show['fname'] . ' ' . $show['lname']) : '' ?></h3>
                    <h3 class="fst-italic fs-5">(<?= isset($employee_id) ? htmlspecialchars($employee_id) : '' ?>)</h3>
                <?php endif; ?> -->
                <h2>HPL Gamedesign Corporation</h2>
                <p>82 Road 3 Project 6 Quezon City, Metro Manila, 1100</p>
                <p>admin@hplgamedesign.com ᐧ 09202773422 ᐧ (02) 8 808 6920</p>

            </div>
            <!-- <a href="/employee">
                <button class="btn btn-danger" id="closeModal">X</button>
            </a> -->
        </div>
        <div class="card-body p-3">
            <h2 class="text-center mb-5">EMPLOYEE EQUIPMENT AGREEMENT</h2>
            <section>
                <p class="text-justify text-wrap" style="line-height: 2em;">
                    I, <span class="fw-bold fs-5 fst-italic" style="text-decoration: underline;">
                        &emsp;<?= isset($show) ? htmlspecialchars($show['fname'] . ' ' . $show['lname']) : '' ?>&emsp;
                    </span>, hereby acknowledge and agree to the following terms and conditions regarding the equipment
                    supplied to me by HPL Gamedesign Corporation, referred to as the Company:
                    <br><br>
                    Equipment Care and Responsibility: I agree to take proper care of all equipment supplied to me by
                    the
                    Company. This includes, but is not limited to, laptops, cell phones, monitors, software licenses, or
                    any other company-provided equipment deemed necessary by Company management for the performance of
                    my job duties. Proper care entails safeguarding the equipment from damage and ensuring its
                    maintenance in good working condition.
                    <br><br>
                    Equipment Return Policy: Upon termination of my employment, whether by resignation or termination, I
                    understand and agree to return all Company-supplied equipment within the specified time-frames:
                    <br><br>
                    ● All employees, including those working remotely or on temporary work-from-home arrangements,
                    are
                    required to promptly return all issued equipment when instructed by the Company within 72hrs.
                    <br><br>
                    ● Following resignation, all issued equipment must be returned within 24 hours.
                    <br><br>
                    Condition of Returned Equipment: I acknowledge that all equipment must be returned in proper
                    working
                    order. Any damage to or malfunction of the equipment beyond normal wear and tear may result in
                    financial responsibility on my part.
                    <br><br>
                    Business Use Only: I understand and agree that any equipment provided by the Company is to be
                    used
                    solely for business purposes and shall not be used for personal activities or non-work-related
                    endeavors.
                    <br><br>
                    Consequences of Non-Compliance: Failure to return any equipment supplied by the Company after
                    the
                    termination of my employment may be considered theft and may result in criminal prosecution by the
                    Company. Additionally, I acknowledge that failure to comply with the terms of this agreement may
                    lead to disciplinary action, including potential legal consequences.
                    <br><br>
                    Termination Conditions: The terms of this agreement apply regardless of the circumstances of
                    termination, including resignation, termination for cause, or termination without cause.
                </p>
            </section>

            <table class="table table-bordered my-5">
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
            <section class="text-center">
                <p>By signing below, I acknowledge that I have reviewed each point of this agreement and agree to all
                    the conditions above. </p>
            </section>
            <div>
                <table class="table table-bordered">
                    <thead>
                        <tr class="fw-bold">
                            <td>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Date Released:</div>
                                    <?php
                                    if (isset($rows[0]['created_at'])) {
                                        // Convert the created_at to a DateTime object and format it
                                        $date = new DateTime($rows[0]['created_at']);
                                        echo htmlspecialchars($date->format('F d, Y'));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </div>

                            </td>
                            <td class="d-flex align-items-center gap-5 justify-content-end" id="custody-radio">
                                <input type="radio" name="e_status" id="e-new-hire">
                                <label for="e-new-hire">New Hire</label>
                                <input type="radio" name="e_status" id="e-wfh">
                                <label for="e-wfh">WFH</label>
                                <input type="radio" name="e_status" id="e-temp">
                                <label for="e-temp">TEMP WFH</label>
                            </td>
                        </tr>
                        <tr class="fw-bold">
                            <td colspan="2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>Department:</div>
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <form action="/esignature?employee_id=<?= $employee_id ?>" method="post"
                                    id="e-signature" enctype="multipart/form-data">
                                    <div class="input-group">
                                        <?php
                                        // Fetch the image URL from the database
                                        $fetchImage = $conn->query("SELECT signature FROM employee WHERE employee_id = '$employee_id'");
                                        if ($result = $fetchImage->fetch_assoc()) {
                                            $imageUrl = $result['signature'];
                                        } else {
                                            $imageUrl = null; // Default to null if no image is found
                                        }
                                        ?>

                                        <!-- Show file input and upload button ONLY if no image exists -->
                                        <?php if (empty($imageUrl)): ?>
                                            <input type="file" class="form-control" name="e-signature" id="e-signature"
                                                aria-describedby="e-signature" aria-label="Upload"
                                                accept=".jpg, .jpeg, .png" required>
                                            <button class="btn btn-dark h-50" type="submit" id="e-signature"
                                                name="signature">Upload</button>
                                        <?php endif; ?>

                                        <!-- Display the uploaded image if it exists -->
                                        <?php if (!empty($imageUrl)): ?>
                                            <div class="d-flex flex-column justify-content-center align-items-center">
                                                <img src="<?= $imageUrl ?>" alt="Employee Signature" class="img-fluid w-25 mt-5">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </form>
                                <h3 class="fst-italic fs-5 mt-3 fw-bold">
                                    <u><?= isset($show) ? htmlspecialchars($show['fname'] . ' ' . $show['lname']) : '' ?></u>
                                </h3>
                            </td>
                            <td class="text-center">
                                <?php
                                // Fetch the image URL from the database
                                $fetchImage = $conn->query("SELECT signature FROM employee WHERE employee_id = '$employee_id'");
                                if ($result = $fetchImage->fetch_assoc()) {
                                    $imageUrl = $result['signature'];
                                } else {
                                    $imageUrl = null; // Default to null if no image is found
                                }
                                ?>

                                <!-- Show file input and upload button ONLY if no image exists -->
                                <?php if (empty($imageUrl)): ?>
                                    <input type="file" class="form-control" name="e-signature" id="e-signature"
                                        aria-describedby="e-signature" aria-label="Upload" accept=".jpg, .jpeg, .png"
                                        required>
                                    <button class="btn btn-dark h-50" type="submit" id="e-signature"
                                        name="signature">Upload</button>
                                <?php endif; ?>

                                <!-- Display the uploaded image if it exists -->
                                <?php if (!empty($imageUrl)): ?>
                                    <div class="d-flex flex-column justify-content-center align-items-center">
                                        <img src="<?= $imageUrl ?>" alt="Employee Signature" class="img-fluid w-25 mt-5">
                                    </div>
                                <?php endif; ?>
                                <h3 class="fst-italic fs-5 mt-3 fw-bold">
                                    <u>JOHN DARVIE CARREON</u>
                                </h3>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>
                                EMPLOYEE NAME & SIGNATURE
                            </td>
                            <td>
                                IT PERSONNEL - NAME & SIGNATURE
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="card-footer p-3 d-flex justify-content-center align-items-center gap-2">
            <p class="not">To ensure the document prints correctly, please enable <strong>Headers and Footers</strong>
                and <strong>Background Graphics</strong> in the print window under <strong>More Settings</strong>.</p>

            <button type="button" class="btn btn-dark w-25" id="printBtn">Print</button>
            <button type="button" class="btn btn-danger w-25" id="cancelPrint">Cancel</button>
        </div>
    </div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const printBtn = document.getElementById('printBtn');
        const cancelBtn = document.getElementById('cancelPrint');

        printBtn.onclick = () => {
            // Force a reflow to ensure styles are applied
            document.body.offsetHeight;

            // Trigger the print dialog
            window.print();
        };

        cancelBtn.onclick = () => {
            window.location = "/employee";
        };
    });

</script>