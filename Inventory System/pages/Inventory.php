<div class="container-fluid table-responsive d-flex flex-column gap-4" id="inventoryDashboard">
    <div class="input-group">
        <div class="form-outline" id="searchAssets">
            <input type="text" id="getAssets" placeholder="SEARCH BY USING COMPUTER ID OR COMPUTER NAME"
                class="form-control border border-black border-2 input-search" />
        </div>
    </div>
    <div class="admin-btn d-flex justify-content-between align-items-center">
        <h2>Inventory Dashboard</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-dark w-auto" id="inventoryBtn">Stocks</button>
            <a href="/add">
                <button type="button" class="btn btn-dark w-auto" id="addAssets">Add Assets</button>
            </a>
        </div>
    </div>
    <table class="table text-center table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Computer ID</th>
                <th scope="col">Computer Name</th>
                <th scope="col">Specifications</th>
                <th scope="col">History</th>
            </tr>
        </thead>
        <tbody id="showdata">

            <?php
            $fetchInventory = mysqli_query($conn, "SELECT * FROM computer  GROUP BY cname ORDER BY created_at");

            if (mysqli_num_rows($fetchInventory) == 0) {
                // Display message when no data is found
                echo "<tr><td colspan='6'>No assets found.</td></tr>";
            } else {
                while ($result = mysqli_fetch_assoc($fetchInventory)) {
                    ?>
                    <tr>
                        <td>
                            <p class="my-1"><?= $result['cname_id'] ?></p>
                        </td>
                        <td>
                            <p class="my-1"><?= $result['cname'] ?></p>
                        </td>
                        <td>
                            <a href="/specs?cname=<?= $result['cname'] ?>">
                                <button type="button" class="btn btn-dark" id="specsBtn">View</button>
                            </a>
                        </td>
                        <td>
                            <a href="/history?cname_id=<?= $result['cname_id'] ?>">
                                <button type="button" class="btn btn-warning" id="historyBtn">View</button>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>

        </tbody>
    </table>
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
                        url: 'server/jquery/inventory.php', // Make sure this path is correct
                        data: { name: '' }, // Send empty string to fetch all assets
                        success: function (response) {
                            var data = JSON.parse(response);

                            if (data.message) {
                                $("#showdata").html("<tr><td colspan='4'>No assets found</td></tr>");
                            } else {
                                var html = '';
                                data.forEach(function (item) {
                                    html += "<tr>";
                                    html += "<td>" + item.cname_id + "</td>";
                                    html += "<td>" + item.cname + "</td>";
                                    html += "<td><a href='/specs?cname_id=" + item.cname_id + "'><button type='button' class='btn btn-dark' id='specsBtn'>View</button></a></td>";
                                    html += "<td><a href='/history?cname_id=" + item.cname_id + "'><button type='button' class='btn btn-warning' id='historyBtn'>View</button></a></td>";
                                    html += "</tr>";
                                });
                                $("#showdata").html(html); // Inject response into tbody
                            }
                        },
                        error: function () {
                            $("#showdata").html("<tr><td colspan='4'>An error occurred while fetching data.</td></tr>");
                        }
                    });

                    return; // Stop the AJAX call if input is empty
                }

                // Continue with the original search if input is not empty
                $.ajax({
                    method: 'POST',
                    url: 'server/jquery/inventory.php', // Make sure this path is correct
                    data: { name: getAssets },
                    success: function (response) {
                        try {
                            var data = JSON.parse(response);

                            if (data.message) {
                                $("#showdata").html("<tr><td colspan='4'>No assets found</td></tr>");
                            } else {
                                var html = '';
                                data.forEach(function (item) {
                                    html += "<tr>";
                                    html += "<td>" + item.cname_id + "</td>";
                                    html += "<td>" + item.cname + "</td>";
                                    html += "<td><a href='/specs?cname_id=" + item.cname_id + "'><button type='button' class='btn btn-dark' id='historyBtn'>View</button></a></td>";
                                    html += "<td><a href='/history?cname_id=" + item.cname_id + "'><button type='button' class='btn btn-warning' id='historyBtn'>View</button></a></td>";
                                    html += "</tr>";
                                });
                                $("#showdata").html(html); // Inject response into tbody
                            }
                        } catch (e) {
                            console.error("Error parsing JSON response", e);
                            $("#showdata").html("<tr><td colspan='4'>An error occurred while fetching data.</td></tr>");
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
        <div class="container p-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">COMPONENTS</th>
                        <th scope="col">COUNT</th>
                        <th scope="col">AVAILABLE PART</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $limit = 10; // Display 10 records per page
                    $pagination = isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
                    $offset = ($pagination - 1) * $limit;

                    // Query to get the total number of records (counting all assets)
                    $totalResult = mysqli_query($conn, "SELECT COUNT(*) as total FROM assets");
                    if (!$totalResult) {
                        die("Error fetching total rows: " . mysqli_error($conn));
                    }

                    $totalRows = mysqli_fetch_assoc($totalResult)['total'] ?? 0;
                    $totalPages = ceil($totalRows / $limit);

                    // Adjust pagination if out of bounds
                    if ($pagination > $totalPages) {
                        $pagination = $totalPages > 0 ? $totalPages : 1;
                    }

                    // Query to count occurrences of each asset and compare with computer table (cname_id)
                    $assetQuery = "
                        SELECT 
                            a.assets, 
                            COUNT(a.assets_id) AS total_assets, 
                            COUNT(c.assets_id) AS allocated_assets, 
                            (COUNT(a.assets_id) - COUNT(c.assets_id)) AS in_stock
                        FROM assets a 
                        LEFT JOIN computer c ON a.assets_id = c.assets_id AND c.cname_id IS NOT NULL
                        GROUP BY a.assets
                        LIMIT $limit OFFSET $offset
                    ";

                    $result = mysqli_query($conn, $assetQuery);
                    if (!$result) {
                        die("Error fetching assets: " . mysqli_error($conn));
                    }

                    // Generate table rows
                    while ($row = mysqli_fetch_assoc($result)) {
                        $assetName = $row['assets'];
                        $totalAssets = $row['total_assets'];
                        $allocatedAssets = $row['allocated_assets'];
                        $stock = $row['in_stock']; // Subtract allocated assets from total and check for available stock
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($assetName, ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($totalAssets, ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($stock, ENT_QUOTES, 'UTF-8') ?></td>
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
</div>