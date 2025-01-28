<?php
require_once "server/employee.php";
include 'admin/auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <div class="container-fluid table-responsive d-flex flex-column gap-4" id="inventoryDashboard">

        <div class="admin-btn d-flex justify-content-between align-items-center">
            <h2>Employee Data</h2>
            <div class="form-outline" id="searchAssets">
                <input type="text" id="getAssets" placeholder="Search using Employee ID, First Name or Last Name"
                    class="form-control border border-black border-2 input-search" />
            </div>
        </div>

        <table class="table text-center">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Address</th>
                    <th scope="col">Status</th>
                    <th scope="col">History</th>
                </tr>
            </thead>
            <tbody id="showdata">

                <?php
                $fetchData = mysqli_query($conn, "SELECT * FROM employee");
                while ($result = mysqli_fetch_assoc($fetchData)) {
                    // Map status codes to their respective labels
                    $statuses = [
                        1 => 'WFH',
                        2 => 'On-site',
                        3 => 'Resigned',
                    ];

                    // Get status label based on the value in database, or default to 'Unknown'
                    $status = $statuses[(int) $result['status']] ?? 'Unknown';
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($result['employee_id']) ?></td>
                        <td><?= htmlspecialchars($result['fname'] . ' ' . $result['lname']) ?></td>
                        <td><?= htmlspecialchars($result['contact']) ?></td>
                        <td><?= htmlspecialchars($result['street'] . ' ' . $result['brgy'] . ' ' . $result['city'] . ' ' . $result['province'] . ' ' . $result['region'] . ' ' . $result['zip']) ?>
                        </td>
                        <td><?= $status ?></td>
                        <td>
                            <a href="view.php?employee_id= <?= $result['employee_id'] ?>">
                                <button class="btn btn-dark">View</button>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
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

    </div>

    <script>
        $(document).ready(function () {
            var currentPage = 1; // Track the current page globally

            function fetchData(page) {
                currentPage = page; // Update the global currentPage variable
                var getAssets = $('#getAssets').val().trim(); // Get search query
                $.ajax({
                    method: 'POST',
                    url: 'server/fetch_employee.php',
                    data: {
                        name: getAssets,  // Include search query
                        page: page        // Include current page for pagination
                    },
                    success: function (response) {
                        try {
                            var data = JSON.parse(response);
                            if (data.data.length > 0) {
                                var html = '';

                                // Status mapping similar to PHP
                                var statuses = {
                                    1: 'WFH',
                                    2: 'On-site',
                                    3: 'Resigned'
                                };

                                data.data.forEach(function (item) {
                                    var statusLabel = statuses[item.status] || 'Unknown'; // Default to 'Unknown' if no match
                                    html += "<tr>";
                                    html += "<td>" + item.employee_id + "</td>";
                                    html += "<td>" + item.fname + ' ' + item.lname + "</td>";
                                    html += "<td>" + item.contact + "</td>";
                                    html += "<td>" + item.street + ' ' + item.brgy + ' ' + item.city + ' ' + item.province + ' ' + item.region + ' ' + item.zip + "</td>";
                                    html += "<td>" + statusLabel + "</td>";
                                    html += `<td>
                                                <a href="view.php?employee_id=${item.employee_id}">
                                                    <button class="btn btn-dark">View</button>
                                                </a>
                                            </td>`;
                                    html += "</tr>";
                                });

                                $('#showdata').html(html); // Inject data into the table

                                // Create pagination links dynamically
                                var paginationHtml = '';
                                for (var i = 1; i <= data.totalPages; i++) {
                                    var activeClass = (i === currentPage) ? 'active' : '';
                                    paginationHtml += "<li class='page-item " + activeClass + "'><a class='page-link' href='#' data-page='" + i + "'>" + i + "</a></li>";
                                }
                                $('#pagination').html(paginationHtml); // Inject pagination links

                            } else {
                                $('#showdata').html("<tr><td colspan='6'>No assets found</td></tr>");
                            }
                        } catch (e) {
                            console.error("Error parsing JSON response", e);
                            $('#showdata').html("<tr><td colspan='6'>An error occurred while fetching data.</td></tr>");
                        }
                    },
                    error: function () {
                        $('#showdata').html("<tr><td colspan='6'>An error occurred while fetching data.</td></tr>");
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


</body>

</html>