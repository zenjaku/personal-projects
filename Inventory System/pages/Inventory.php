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
        </tbody>
    </table>
    <div class="text-white">
        <nav>
            <ul class="bg-dark rounded p-2 d-flex justify-content-center align-items-center gap-3 border border-2 border-white"
                id="pagination">
                <!-- Pagination links will be inserted dynamically by JavaScript -->
            </ul>
        </nav>
    </div>
    <script>
        $(document).ready(function () {
            var currentPage = 1; // Track the current page globally

            // Function to fetch data with pagination
            function fetchData(page) {
                currentPage = page; // Update the global currentPage variable
                var getAssets = $('#getAssets').val().trim(); // Get search query

                $.ajax({
                    method: 'POST',
                    url: 'server/jquery/inventory.php', // Ensure this path is correct
                    data: {
                        name: getAssets,  // Include search query
                        page: page        // Include current page for pagination
                    },
                    success: function (response) {
                        try {
                            var data = JSON.parse(response);

                            if (data.message) {
                                $("#showdata").html("<tr><td colspan='4'>No assets found</td></tr>");
                            } else {
                                var html = '';
                                data.data.forEach(function (item) {
                                    html += "<tr>";
                                    html += "<td>" + item.cname_id + "</td>";
                                    html += "<td>" + item.cname + "</td>";
                                    html += "<td><a href='/specs?cname_id=" + item.cname_id + "'><button type='button' class='btn btn-dark'>View</button></a></td>";
                                    html += "<td><a href='/history?cname_id=" + item.cname_id + "'><button type='button' class='btn btn-warning'>View</button></a></td>";
                                    html += "</tr>";
                                });
                                $("#showdata").html(html); // Inject response into tbody

                                // Pagination logic
                                var paginationHtml = '';
                                for (var i = 1; i <= data.totalPages; i++) {
                                    var activeClass = (i === currentPage) ? 'active' : '';
                                    paginationHtml += "<li class='page-item " + activeClass + "'><a class='page-link' href='#' data-page='" + i + "'>" + i + "</a></li>";
                                }
                                $('#pagination').html(paginationHtml); // Inject pagination links
                            }
                        } catch (e) {
                            console.error("Error parsing JSON response", e);
                            $("#showdata").html("<tr><td colspan='4'>An error occurred while fetching data.</td></tr>");
                        }
                    },
                    error: function () {
                        $("#showdata").html("<tr><td colspan='4'>An error occurred while fetching data.</td></tr>");
                    }
                });
            }

            // Initial data fetch when the page loads
            fetchData(1);

            // Handle pagination link clicks
            $(document).on('click', '#pagination .page-link', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                fetchData(page); // Fetch data for the clicked page
            });

            // Search function when typing in the search input
            $('#getAssets').on('keyup', function () {
                fetchData(1); // Reload data from the first page when the search input changes
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
                    $totalResult = mysqli_query($conn, "SELECT COUNT(DISTINCT assets_id) as total FROM assets");
                    if (!$totalResult) {
                        die("Error fetching total rows: " . mysqli_error($conn));
                    }

                    $totalRows = mysqli_fetch_assoc($totalResult)['total'] ?? 0;
                    $totalPages = ceil($totalRows / $limit);

                    // Adjust pagination if out of bounds
                    if ($pagination > $totalPages) {
                        $pagination = $totalPages > 0 ? $totalPages : 1;
                    }

                    // Query to fetch and group assets by their name, and count the occurrences of each asset
                    $assetQuery = "SELECT a.assets, a.assets_id, COUNT(a.assets_id) AS total_assets
                       FROM assets a
                       GROUP BY a.assets
                       LIMIT $limit OFFSET $offset
                    ";

                    $result = mysqli_query($conn, $assetQuery);
                    if (!$result) {
                        die("Error fetching assets: " . mysqli_error($conn));
                    }

                    // Fetch and unserialize assets_ids from computer table
                    $computerQuery = "SELECT assets_id FROM computer WHERE cname_id IS NOT NULL";
                    $computerResult = mysqli_query($conn, $computerQuery);
                    if (!$computerResult) {
                        die("Error fetching computer data: " . mysqli_error($conn));
                    }

                    $allocatedAssets = [];
                    while ($row = mysqli_fetch_assoc($computerResult)) {
                        // Unserialize the assets_id if it's stored serialized
                        $assetsIdArray = unserialize($row['assets_id']);
                        $allocatedAssets = array_merge($allocatedAssets, $assetsIdArray); // Merge into the allocated array
                    }

                    // Generate table rows for assets
                    while ($row = mysqli_fetch_assoc($result)) {
                        $assetName = $row['assets'];
                        $assetId = $row['assets_id'];
                        $totalAssetsCount = $row['total_assets']; // Count of assets for each asset type
                    
                        // Count the number of allocated assets for the current asset
                        $allocatedCount = 0;
                        foreach ($allocatedAssets as $allocatedAssetId) {
                            // Extract just the asset type (e.g., "CPU" from "CPU_987-654-321")
                            $allocatedAssetType = explode('_', $allocatedAssetId)[0];
                            $currentAssetType = explode('_', $assetId)[0];

                            if ($allocatedAssetType == $currentAssetType) {
                                $allocatedCount++;
                            }
                        }

                        // Calculate in_stock (total - allocated)
                        $inStock = $totalAssetsCount - $allocatedCount;

                        // Output the row for this asset
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($assetName, ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($totalAssetsCount, ENT_QUOTES, 'UTF-8') ?></td>
                            <!-- Display the count of the asset -->
                            <td><?= htmlspecialchars($inStock, ENT_QUOTES, 'UTF-8') ?></td> <!-- Available parts -->
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