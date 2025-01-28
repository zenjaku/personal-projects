<?php
// require_once "server/inventory.php";
include 'admin/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
</head>

<body>
    <div class="container-fluid table-responsive d-flex flex-column gap-4" id="inventoryDashboard">
        <div class="input-group">
            <div class="form-outline" id="searchAssets">
                <input type="text" id="getAssets" placeholder="Search Assets using Serial Number"
                    class="form-control border border-black border-2 input-search" />
            </div>
        </div>
        <div class="admin-btn d-flex justify-content-between align-items-center">
            <h2>Inventory Dashboard</h2>
            <div class="d-flex gap-2">
                <button class="btn btn-dark w-auto" id="inventoryBtn">Inventory Count</button>
                <a href="index.php?page=add">
                    <button type="button" class="btn btn-dark w-auto" id="addAssets">Add Assets</button>
                </a>
            </div>
        </div>
        <table class="table text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Assets ID</th>
                    <th scope="col">Assets</th>
                    <th scope="col">Brand</th>
                    <th scope="col">Model</th>
                    <th scope="col">S/N</th>
                    <th scope="col">History</th>
                </tr>
            </thead>
            <tbody id="showdata">

                <?php

                $limit = 5; // Display 10 records per page
                $pages = isset($_GET['pages']) && (int) $_GET['pages'] > 0 ? (int) $_GET['pages'] : 1; // Ensure page is positive
                $offset = ($pages - 1) * $limit;

                // Query to get the total number of records (assets)
                $totalResult = mysqli_query($conn, "SELECT COUNT(DISTINCT assets) as total FROM assets");
                if (!$totalResult) {
                    die("Error fetching total rows: " . mysqli_error($conn));
                }

                $totalRows = mysqli_fetch_assoc($totalResult)['total'] ?? 0;
                $totalPages = ceil($totalRows / $limit);

                // Adjust pages if out of bounds
                if ($pages > $totalPages) {
                    $pages = $totalPages > 0 ? $totalPages : 1; // Default to page 1 if no records
                }

                $fetchInventory = mysqli_query($conn, "SELECT * FROM assets ORDER BY created_at LIMIT $limit OFFSET $offset");
                while ($result = mysqli_fetch_assoc($fetchInventory)) {
                    ?>
                    <tr>
                        <td><?= $result['assets_id'] ?></td>
                        <td><?= $result['assets'] ?></td>
                        <td><?= $result['brand'] ?></td>
                        <td><?= $result['model'] ?></td>
                        <td><?= $result['sn'] ?></td>
                        <td>
                            <a href="history.php?assets_id=<?= $result['assets_id'] ?>">
                                <button type="button" class="btn btn-dark" id="historyBtn">View</button>
                            </a>
                        </td>
                    </tr>

                    <?php
                }
                ?>
            </tbody>
        </table>
        <!-- Pagination Links -->
        <div class="text-white">
            <nav>
                <ul class="bg-dark rounded p-2 d-flex justify-content-center align-items-center gap-3 border border-2 border-white"
                    id="pagination">
                    <li class="page-item <?= ($pages == 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pages=1" title="First">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item <?= ($pages == 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pages=<?= $pages - 1 ?>" title="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($pages == $i) ? 'active' : '' ?>">
                            <a class="page-link" href="?pages=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= ($pages == $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pages=<?= $pages + 1 ?>" title="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <li class="page-item <?= ($pages == $totalPages) ? 'disabled' : '' ?>">
                        <a class="page-link" href="?pages=<?= $totalPages ?>" title="Last">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#getAssets').on("keyup", function () {
                var getAssets = $(this).val().trim();

                // If input is empty, fetch all assets or clear the table
                if (getAssets === "") {
                    // Option 1: Clear the table
                    $("#showdata").html(""); // Clear the table when input is empty

                    // Option 2: Fetch all assets (Optional)
                    $.ajax({
                        method: 'POST',
                        url: 'server/inventory.php', // Make sure this path is correct
                        data: { name: '' }, // Send empty string to fetch all assets
                        success: function (response) {
                            var data = JSON.parse(response);

                            if (data.message) {
                                $("#showdata").html("<tr><td colspan='6'>No assets found</td></tr>");
                            } else {
                                var html = '';
                                data.forEach(function (item) {
                                    html += "<tr>";
                                    html += "<td>" + item.assets_id + "</td>";
                                    html += "<td>" + item.assets + "</td>";
                                    html += "<td>" + item.brand + "</td>";
                                    html += "<td>" + item.model + "</td>";
                                    html += "<td>" + item.sn + "</td>";
                                    html += "<td><a href='history.php?assets_id=" + item.assets_id + "'><button type='button' class='btn btn-dark' id='historyBtn'>View</button></a></td>";
                                    html += "</tr>";
                                });
                                $("#showdata").html(html); // Inject response into tbody
                            }
                        },
                        error: function () {
                            $("#showdata").html("<tr><td colspan='6'>An error occurred while fetching data.</td></tr>");
                        }
                    });

                    return; // Stop the AJAX call if input is empty
                }

                // Continue with the original search if input is not empty
                $.ajax({
                    method: 'POST',
                    url: 'server/inventory.php', // Make sure this path is correct
                    data: { name: getAssets },
                    success: function (response) {
                        try {
                            var data = JSON.parse(response);

                            if (data.message) {
                                $("#showdata").html("<tr><td colspan='6'>No assets found</td></tr>");
                            } else {
                                var html = '';
                                data.forEach(function (item) {
                                    html += "<tr>";
                                    html += "<td>" + item.assets_id + "</td>";
                                    html += "<td>" + item.assets + "</td>";
                                    html += "<td>" + item.brand + "</td>";
                                    html += "<td>" + item.model + "</td>";
                                    html += "<td>" + item.sn + "</td>";
                                    html += "<td><a href='history.php?assets_id=" + item.assets_id + "'><button type='button' class='btn btn-dark' id='historyBtn'>View</button></a></td>";
                                    html += "</tr>";
                                });
                                $("#showdata").html(html); // Inject response into tbody
                            }
                        } catch (e) {
                            console.error("Error parsing JSON response", e);
                            $("#showdata").html("<tr><td colspan='6'>An error occurred while fetching data.</td></tr>");
                        }
                    },
                    error: function () {
                        $("#showdata").html("<tr><td colspan='6'>An error occurred while fetching data.</td></tr>");
                    }
                });
            });
        });


    </script>



    <div class="overlay hidden" id="overlay"></div>
    <div id="inventory" class="bg-body-tertiary w-75 hidden">
        <div class="container p-3 table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Hardware</th>
                        <!-- <th scope="col">Serial Number</th> -->
                        <th scope="col">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $limit = 1; // Display 10 records per page
                    $pagination = isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1; // Ensure page is positive
                    $offset = ($pagination - 1) * $limit;

                    // Query to get the total number of records (assets)
                    $totalResult = mysqli_query($conn, "SELECT COUNT(DISTINCT assets) as total FROM assets");
                    if (!$totalResult) {
                        die("Error fetching total rows: " . mysqli_error($conn));
                    }

                    $totalRows = mysqli_fetch_assoc($totalResult)['total'] ?? 0;
                    $totalPages = ceil($totalRows / $limit);

                    // Adjust pagination if out of bounds
                    if ($pagination > $totalPages) {
                        $pagination = $totalPages > 0 ? $totalPages : 1; // Default to page 1 if no records
                    }

                    // Query to get the assets with pagination
                    $assetQuery = "SELECT assets, COUNT(*) as count FROM assets GROUP BY assets LIMIT $limit OFFSET $offset";
                    $result = mysqli_query($conn, $assetQuery);
                    if (!$result) {
                        die("Error fetching assets: " . mysqli_error($conn));
                    }

                    // Generate table rows
                    while ($row = mysqli_fetch_assoc($result)) {
                        $hardware = $row['assets'];
                        // $serialNumber = $row['sn'];
                        $count = $row['count'];
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($hardware, ENT_QUOTES, 'UTF-8') ?></td>
                            <!-- <td><?= htmlspecialchars($serialNumber, ENT_QUOTES, 'UTF-8') ?></td> -->
                            <td><?= htmlspecialchars($count, ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>

            <!-- Pagination Links -->
            <div class="text-white">
                <nav>
                    <ul class="bg-dark rounded p-2 d-flex justify-content-center align-items-center gap-3 border border-2 border-white"
                        id="pagination">
                        <li class="page-item <?= ($pagination == 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=1" title="First">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item <?= ($pagination == 1) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $pagination - 1 ?>" title="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($pagination == $i) ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&showModal=1"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($pagination == $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $pagination + 1 ?>" title="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <li class="page-item <?= ($pagination == $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $totalPages ?>" title="Last">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>
</body>

</html>