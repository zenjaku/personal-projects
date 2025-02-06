<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Parts and Components</h2>
                <div id="searchAssets" class="form-outline">
                    <input type="text" class="form-control parts-search" name="assets_id" id="getAssets"
                        placeholder="Search by Serial Number">
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ASSOCIATED PC</th>
                        <th>SPECIFIED</th>
                        <th>BRAND</th>
                        <th>MODEL</th>
                        <th>S/N</th>
                        <th>ADD TO</th>
                    </tr>
                </thead>
                <tbody id="showdata">
                    <!-- <tr>
                        <td>ASSETS ID</td>
                        <td>SPECIFIED</td>
                        <td>BRAND</td>
                        <td>MODEL</td>
                        <td>S/N</td>
                        <td>ACTION</td>
                    </tr> -->
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
    </div>
</div>
<script>
    $(document).ready(function () {
        var currentPage = 1; // Track the current page globally

        // Function to fetch data based on the search query
        function fetchData(page, searchQuery = '') {
            currentPage = page; // Update the global currentPage variable
            $.ajax({
                method: 'POST',
                url: 'server/jquery/parts.php',
                data: {
                    name: searchQuery,  // Send search query (empty if no search)
                    page: page          // Include current page for pagination
                },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.data.length > 0) {
                            var html = '';

                            data.data.forEach(function (item) {
                                html += "<tr>";
                                html += "<td>" + item.cname + "</td>";
                                html += "<td>" + item.assets + "</td>";
                                html += "<td>" + item.brand + "</td>";
                                html += "<td>" + item.model + "</td>";
                                html += "<td>" + item.sn + "</td>";

                                // Check if asset is installed, then change the button state and text
                                let buttonText = item.status === 'installed' ? 'Installed' : 'Install';
                                let buttonClass = item.status === 'installed' ? 'btn btn-secondary' : 'btn btn-dark';
                                let isDisabled = item.status === 'installed' ? 'disabled' : '';  // Disable button if installed

                                if (item.status === 'installed') {
                                    html += `<td>
                                            <a href="/add-to?cname=${item.assets_id}" style="pointer-events: none; opacity: 0.5;">
                                                <button class="${buttonClass}" ${isDisabled}>
                                                    ${buttonText}
                                                </button>
                                            </a>
                                        </td>`;
                                } else {
                                    html += `<td>
                                            <a href="/add-to?assets_id=${item.assets_id}">
                                                <button class="${buttonClass}" ${isDisabled}>
                                                    ${buttonText}
                                                </button>
                                            </a>
                                        </td>`;
                                }

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
                            $('#showdata').html("<tr><td class='text-center' colspan='6'>No parts found</td></tr>");
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

        // Initial data fetch when the page loads (with empty search query)
        fetchData(1, '');

        // Handle pagination link clicks
        $(document).on('click', '#pagination .page-link', function (e) {
            e.preventDefault();
            var page = $(this).data('page');
            var getAssets = $('#getAssets').val().trim();  // Get the current search query
            fetchData(page, getAssets); // Fetch data for the clicked page, using the current search query
        });

        // Search function when typing in the search input
        $('#getAssets').on('keyup', function () {
            var searchQuery = $(this).val().trim();
            if (searchQuery === '') {
                // If the input is empty, fetch all data
                fetchData(1, '');
            } else {
                // If there's a query, fetch data based on the search
                fetchData(1, searchQuery);
            }
        });
    });

</script>