<?php
require('server/drop-downs/parts.php');
?>
<div class="row">
    <div class="col-6 py-5">
        <div class="card">
            <div class="card-header">
                <h3>Build PC</h3>
            </div>
            <form action="/build-pc" method="post" id="buildForm">
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" name="cname" id="cname" class="form-control" placeholder="Computer Name"
                            required>
                        <label for="cname">Computer Name</label>
                        <table class="table table-bordered text-center table-responsive">
                            <thead class="table-dark">
                                <tr>
                                    <td>ASSETS ID</td>
                                    <td>SPECIFIED</td>
                                    <td>BRAND</td>
                                    <td>MODEL</td>
                                    <td>S/N</td>
                                    <td>REMOVE</td>
                                </tr>
                            </thead>
                            <tbody id="showassets">

                                <script>
                                    $(document).ready(function () {
                                        var currentPage = 1;
                                        var addedAssets = []; // Track added asset IDs
                                        var singleAddParts = ['CPU', 'Motherboard', 'GPU', 'Power Supply']; // Parts that can only be added once

                                        // Function to fetch data based on search term
                                        function fetchData(page) {
                                            currentPage = page;
                                            var getAssets = $('#getAssets').val().trim();

                                            $.ajax({
                                                method: 'POST',
                                                url: 'server/jquery/fetch_parts.php',
                                                data: {
                                                    name: getAssets,
                                                    page: page,
                                                    exclude: addedAssets // Send the excluded assets
                                                },
                                                success: function (response) {
                                                    console.log("Response from fetch_parts.php:", response); // Log the response for debugging
                                                    try {
                                                        var data = JSON.parse(response);
                                                        var html = '';
                                                        if (data.data.length > 0) {
                                                            data.data.forEach(function (item) {
                                                                html += `<tr>
                                                                            <td>${item.assets_id}</td>
                                                                            <td>${item.assets}</td>
                                                                            <td>${item.brand}</td>
                                                                            <td>${item.model}</td>
                                                                            <td>${item.sn}</td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-warning mb-3 add-part" data-assets-id="${item.assets_id}" data-assets="${item.assets}">
                                                                                    <i class="fa-solid fa-circle-plus"></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr>`;
                                                            });
                                                        } else {
                                                            html = '<tr><td colspan="6">No parts found</td></tr>';
                                                        }
                                                        $('#showdata').html(html);
                                                    } catch (e) {
                                                        console.error("Error parsing response:", e);
                                                    }
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error("AJAX Error:", error);
                                                }
                                            });
                                        }

                                        // Fetch data on page load
                                        fetchData(1);

                                        // Add Part to Build
                                        $(document).on('click', '.add-part', function () {
                                            var row = $(this).closest('tr');
                                            var assets_id = $(this).data('assets-id');
                                            var assets = $(this).data('assets');
                                            var brand = row.find('td:eq(2)').text();
                                            var model = row.find('td:eq(3)').text();
                                            var sn = row.find('td:eq(4)').text();

                                            if (addedAssets.includes(assets_id)) {
                                                showToast('This part is already added.', 'error');
                                                return;
                                            }

                                            // Check if the part is in singleAddParts and already added
                                            if (singleAddParts.includes(assets)) {
                                                var alreadyAdded = $('#showassets').find(`input[name="assets[]"][value="${assets}"]`).length > 0;
                                                if (alreadyAdded) {
                                                    showToast(`Only one ${assets} can be added.`, 'error');
                                                    return;
                                                }
                                            }

                                            // Add the part to the list
                                            addedAssets.push(assets_id);
                                            $('#showassets').append(`<tr>
                                                                        <td><input type="text" class="border-0" readonly name="assets_id[]" value="${assets_id}"></td>
                                                                        <td><input type="text" class="border-0" readonly name="assets[]" value="${assets}"></td>
                                                                        <td><input type="text" class="border-0" readonly name="brand[]" value="${brand}"></td>
                                                                        <td><input type="text" class="border-0" readonly name="model[]" value="${model}"></td>
                                                                        <td><input type="text" class="border-0" readonly name="sn[]" value="${sn}"></td>
                                                                        <td><button type="button" class="btn btn-danger mb-3 remove-part"><i class="fa-solid fa-trash-can"></i></button></td>
                                                                    </tr>`);

                                            showToast(`${assets} added successfully.`, 'success');
                                        });

                                        // Remove Part from Build
                                        $(document).on('click', '.remove-part', function () {
                                            var row = $(this).closest('tr');
                                            var assets_id = row.find('input[name="assets_id[]"]').val();
                                            var assets = row.find('input[name="assets[]"]').val();

                                            // Remove from the list
                                            addedAssets = addedAssets.filter(id => id !== assets_id);
                                            row.remove();

                                            showToast(`${assets} removed successfully.`, 'success');
                                        });

                                        // Search handler for real-time search
                                        $('#getAssets').on('input', function () {
                                            fetchData(1); // Reload parts on every search term change
                                        });

                                        // Function to show toast notifications
                                        function showToast(message, status) {
                                            const bgColor = status === 'success' ? 'warning' : 'danger';
                                            const textColor = bgColor === 'danger' ? 'text-white' : '';
                                            const toast = document.createElement('div');
                                            toast.className = `toast show bg-${bgColor} ${textColor}`;
                                            toast.setAttribute('role', 'alert');
                                            toast.innerHTML = `
                                                                <div class="toast-body justify-content-between d-flex">
                                                                    ${message}
                                                                    <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                                                                </div>
                                                            `;
                                            let toastContainer = document.querySelector('.toast-container');
                                            if (!toastContainer) {
                                                toastContainer = document.createElement('div');
                                                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                                                document.body.appendChild(toastContainer);
                                            }
                                            toastContainer.appendChild(toast);
                                            setTimeout(() => toast.remove(), 3000);
                                        }
                                    });
                                </script>



                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-dark" id="submitBtn" name="build-pc">Save</button>
                    <button type="reset" class="btn btn-danger" onclick="window.location = ''">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-5 py-5">
        <div class="">
            <table class="table table-bordered text-center table-responsive">
                <div id="searchAssets" class="form-outline">
                    <input type="text" class="form-control parts-search" name="assets_id" id="getAssets"
                        placeholder="Search by Serial Number">
                </div>
                <thead class="table-dark">
                    <tr>
                        <td>ASSETS ID</td>
                        <td>SPECIFIED</td>
                        <td>BRAND</td>
                        <td>MODEL</td>
                        <td>S/N</td>
                        <td>ADD</td>
                    </tr>
                </thead>
                <tbody id="showdata">
                    <tr>
                        <td>ASSETS ID</td>
                        <td>SPECIFIED</td>
                        <td>BRAND</td>
                        <td>MODEL</td>
                        <td>S/N</td>
                        <td>
                            <button type="button" class="btn btn-warning mb-3 add-part">
                                <i class="fa-solid fa-circle-plus"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <!-- <tfoot>
                    <tr>
                        <td colspan="6">
                            <div class="text-white">
                                <nav>
                                    <ul class="bg-dark rounded p-2 d-flex justify-content-center align-items-center gap-3 border border-2 border-white"
                                        id="pagination">
                                        Pagination links will be inserted dynamically by JavaScript
                                    </ul>
                                </nav>
                            </div>
                        </td>
                    </tr>
                </tfoot> -->
            </table>

        </div>
    </div>
</div>

<script>
    // Function to show toast notifications
    function showToast(message, status) {
        // Define colors based on status
        const bgColor = status === 'success' ? 'warning' : 'danger';
        const textColor = bgColor === 'danger' ? 'text-white' : '';

        // Create the toast element
        const toast = document.createElement('div');
        toast.className = `toast show bg-${bgColor} ${textColor}`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
        <div class="toast-body justify-content-between d-flex">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
    `;

        // Create the toast container if it doesn't exist
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        // Append the toast to the container
        toastContainer.appendChild(toast);

        // Automatically remove the toast after 3 seconds
        setTimeout(() => toast.remove(), 3000);
    }
    $(document).ready(function () {
        var isCnameValid = false; // Flag to track if cname is valid
        const submitBtn = document.getElementById('submitBtn');

        submitBtn.disabled = true; // Correct way to disable the button initially

        // Function to check if cname exists
        function checkCnameExists(cname) {
            $.ajax({
                method: 'POST',
                url: 'server/jquery/check_cname.php', // Ensure this file handles the check
                data: { cname: cname },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.exists) {
                        showToast('Computer name already exists. Please choose a different name.', 'error');
                        isCnameValid = false;
                    } else {
                        isCnameValid = true;
                    }
                    submitBtn.disabled = !isCnameValid; // Enable or disable the button based on validation
                },
                error: function () {
                    showToast('Error checking computer name. Please try again.', 'error');
                    isCnameValid = false;
                    submitBtn.disabled = true;
                }
            });
        }

        // Event listener for cname input field
        $('#cname').on('input', function () {
            var cname = $(this).val().trim();
            if (cname.length > 0) {
                checkCnameExists(cname);
            } else {
                isCnameValid = false;
                submitBtn.disabled = true; // Ensure the button is disabled if input is empty
            }
        });
    });


</script>