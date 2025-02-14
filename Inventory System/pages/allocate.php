<?php
require_once "server/drop-downs/allocate.php";
require_once "server/drop-downs/transfer.php";
require_once "server/drop-downs/return.php";

$assets = [];
while ($row = mysqli_fetch_assoc($assetsResult)) {
    $assets[] = $row;
}

// $transfer = [];
// while ($row = mysqli_fetch_assoc($transferIDResult)) {
//     $transfer[] = $row;
// }
?>
<div class="container py-5">
    <div class="row">
        <!-- Allocate PC -->
        <div class="col-4">
            <form action="/allocation-assets" method="post" id="allocateForm">
                <div class="card">
                    <div class="card-header">
                        <h2>Allocation of PC</h2>
                    </div>
                    <div class="card-body my-5">
                        <div class="d-flex">
                            <div class="input-group mb-3">
                                <input type="text" name="employee_id" id="search_employee_id"
                                    class="form-control w-50 h-75" placeholder="Search Employee by ID or Name here"
                                    required>
                                <button type="submit" id="search_employee" class="btn btn-dark h-75">Search</button>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column justify-content-center align-content-center gap-3">
                            <select name="employee_id" id="allocate_employee_id" class="form-select" required>
                                <option value="">Employee Name</option>
                                <?php foreach ($employeeIDs as $row): ?>
                                    <option value="<?= htmlspecialchars($row['employee_id']) ?>">
                                        <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <select name="cname_id" id="allocate_cname_id" class="form-select computer-select" required>
                                <option value="">Select a Computer</option>
                                <?php foreach ($assets as $row): ?>
                                    <option value="<?= htmlspecialchars($row['cname_id']) ?>">
                                        <?= htmlspecialchars($row['cname']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-3">
                        <button type="submit" name="allocate" class="btn btn-dark">Submit</button>
                        <button type="reset" class="btn btn-danger resetForm">Cancel</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Transfer PC -->
        <div class="col-4">
            <form action="/transfer-assets" method="post" id="transferForm">
                <div class="card">
                    <div class="card-header">
                        <h2>Transfer PC</h2>
                    </div>
                    <div class="card-body my-5">
                        <div class="d-flex flex-column">
                            <div class="input-group mb-3" id="transfer">
                                <span class="input-group-text h-75" id="label">From</span>
                                <input type="text" name="employee_id" id="search_original_id" class="form-control w-50"
                                    placeholder="Search Employee by ID or Name here">
                                <button type="submit" id="search_original" class="btn btn-dark h-75">Search</button>
                            </div>
                            <div class="input-group mb-3" id="transfer">
                                <span class="input-group-text h-75" id="label">To</span>
                                <input type="text" name="employee_id" id="search_transfer" class="form-control w-50"
                                    placeholder="Search Employee by ID or Name here">
                                <button type="submit" id="transfer_employee" class="btn btn-dark h-75">Search</button>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column justify-content-center align-content-center gap-3">
                            <div class="input-group" id="from">
                                <label class="input-group-text" for="original_employee_id"> From </label>
                                <select name="employee_id" id="original_employee_id" class="form-select" required>
                                    <option value="">Employee Name</option>
                                    <?php foreach ($transferEmployeeID as $row): ?>
                                        <option value="<?= htmlspecialchars($row['employee_id']) ?>">
                                            <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group" id="to">
                                <label class="input-group-text" for="transfer_employee_id"> To </label>
                                <select name="transfer_employee_id" id="transfer_employee_id"
                                    class="form-select computer-select" required>
                                    <option value="">Employee Name</option>
                                    <?php foreach ($transfer as $row): ?>
                                        <option value="<?= htmlspecialchars($row['employee_id']) ?>">
                                            <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-3">
                        <button type="submit" name="transfer" class="btn btn-dark">Submit</button>
                        <button type="reset" class="btn btn-danger resetForm">Cancel</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Return PC -->
        <div class="col-4">
            <form action="/return-assets" method="post" id="returnForm">
                <div class="card">
                    <div class="card-header">
                        <h2>Returned PC</h2>
                    </div>
                    <div class="card-body my-5">
                        <div class="d-flex flex-column" id="search_return">
                            <div class="input-group mb-3">
                                <input type="text" name="employee_id" id="search_id"
                                    class="form-control w-50" placeholder="Search Employee by ID or Name here"
                                    required>
                                <button type="submit" id="return_id" class="btn btn-dark h-75">Search</button>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column justify-content-center align-content-center gap-3">
                            <div class="input-group" id="return">
                                <label class="input-group-text" for="return_employee_id"> Employee</label>
                                <select name="employee_id" id="return_employee_id" class="form-select" required>
                                    <option value="">Employee Name</option>
                                    <?php foreach ($employeeID as $row): ?>
                                        <option value="<?= htmlspecialchars($row['employee_id']) ?>">
                                            <?= htmlspecialchars($row['fname'] . ' ' . $row['lname']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-3">
                        <button type="submit" name="return" class="btn btn-dark">Submit</button>
                        <button type="reset" class="btn btn-danger resetForm">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="d-flex flex-column gap-4 py-4" id="inventoryDashboard">
            <table class="table text-center">
                <tbody id="showdata">
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const resetButtons = document.querySelectorAll(".resetForm"); // Selects all buttons with the class 'resetForm'
        // Loop through all reset buttons and add event listener
        resetButtons.forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();
                window.location.reload();
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#search_employee').click(function (event) {
            event.preventDefault(); // Prevent form submission
            var searchQuery = $('#search_employee_id').val().trim();

            if (searchQuery === "") {
                return;
            }

            $.ajax({
                method: 'POST',
                url: 'server/jquery/search_employee.php',
                data: { searchQuery: searchQuery },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        var employeeDropdown = $('#allocate_employee_id');

                        employeeDropdown.empty(); // Clear existing options
                        // employeeDropdown.append('<option value="">Select Employee</option>');

                        if (data.length === 0) {
                            showToast("No employee data found");
                            return;
                        }

                        data.forEach(function (item) {
                            let newOption = $('<option>', {
                                value: item.employee_id,
                                text: item.fname + ' ' + item.lname
                            });
                            employeeDropdown.append(newOption);
                        });

                        $('#allocate_employee_id').trigger('change');
                        console.log($('#allocate_employee_id').html());


                        // console.log("Dropdown updated with employees:", employeeDropdown.html());
                    } catch (e) {
                        console.error("Error parsing JSON response", e);
                    }
                },
                error: function () {
                    showToast("An error occurred while fetching data.");
                }
            });
        });

        //transfer allocation **from**
        $('#search_original').click(function (event) {
            event.preventDefault(); // Prevent form submission
            var originalQuery = $('#search_original_id').val().trim();

            if (originalQuery === "") {
                return;
            }

            $.ajax({
                method: 'POST',
                url: 'server/jquery/search_employee.php',
                data: { originalQuery: originalQuery },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        var employeeDropdown = $('#original_employee_id');

                        employeeDropdown.empty(); // Clear existing options
                        // employeeDropdown.append('<option value="">Select Employee</option>');

                        if (data.length === 0) {
                            showToast("No employee data found");
                            return;
                        }

                        data.forEach(function (item) {
                            let newOption = $('<option>', {
                                value: item.employee_id,
                                text: item.fname + ' ' + item.lname
                            });
                            employeeDropdown.append(newOption);
                        });

                        $('#original_employee_id').trigger('change');
                        console.log($('#original_employee_id').html());


                        // console.log("Dropdown updated with employees:", employeeDropdown.html());
                    } catch (e) {
                        console.error("Error parsing JSON response", e);
                    }
                },
                error: function () {
                    showToast("An error occurred while fetching data.");
                }
            });
        });

        //transfer allocation **to**
        $('#transfer_employee').click(function (event) {
            event.preventDefault(); // Prevent form submission
            var transferQuery = $('#search_transfer').val().trim();

            if (transferQuery === "") {
                return;
            }

            $.ajax({
                method: 'POST',
                url: 'server/jquery/search_employee.php',
                data: { transferQuery: transferQuery },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        var employeeDropdown = $('#transfer_employee_id');

                        employeeDropdown.empty(); // Clear existing options
                        // employeeDropdown.append('<option value="">Select Employee</option>');

                        if (data.length === 0) {
                            showToast("No employee data found");
                            return;
                        }

                        data.forEach(function (item) {
                            let newOption = $('<option>', {
                                value: item.employee_id,
                                text: item.fname + ' ' + item.lname
                            });
                            employeeDropdown.append(newOption);
                        });

                        $('#transfer_employee_id').trigger('change');
                        console.log($('#transfer_employee_id').html());


                        // console.log("Dropdown updated with employees:", employeeDropdown.html());
                    } catch (e) {
                        console.error("Error parsing JSON response", e);
                    }
                },
                error: function () {
                    showToast("An error occurred while fetching data.");
                }
            });
        });

        // return allocation
        $('#return_id').click(function (event) {
            event.preventDefault(); // Prevent form submission
            var originalQuery = $('#search_id').val().trim();

            if (originalQuery === "") {
                return;
            }

            $.ajax({
                method: 'POST',
                url: 'server/jquery/search_employee.php',
                data: { originalQuery: originalQuery },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        var employeeDropdown = $('#return_employee_id');

                        employeeDropdown.empty(); // Clear existing options
                        // employeeDropdown.append('<option value="">Select Employee</option>');

                        if (data.length === 0) {
                            showToast("No employee data found");
                            return;
                        }

                        data.forEach(function (item) {
                            let newOption = $('<option>', {
                                value: item.employee_id,
                                text: item.fname + ' ' + item.lname
                            });
                            employeeDropdown.append(newOption);
                        });

                        $('#return_employee_id').trigger('change');
                        console.log($('#return_employee_id').html());


                        // console.log("Dropdown updated with employees:", employeeDropdown.html());
                    } catch (e) {
                        console.error("Error parsing JSON response", e);
                    }
                },
                error: function () {
                    showToast("An error occurred while fetching data.");
                }
            });
        });


        function showToast(message) {
            var toast = $('<div class="toast align-items-center text-white bg-danger border-0 position-fixed top-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">' +
                '<div class="d-flex">' +
                '<div class="toast-body">' + message + '</div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                '</div>' +
                '</div>');

            $('body').append(toast);
            var toastElement = new bootstrap.Toast(toast[0]);
            toastElement.show();

            setTimeout(function () {
                toast.remove();
            }, 3000);
        }
    });

    // script for allocating pc
    $(document).ready(function () {

        $('#allocate_cname_id').on("change", function () {
            var assetID = $(this).val().trim();
            var formID = $(this).closest('form').attr('id');

            if (assetID === "") {
                $("#showdata").html("");
                return;
            }

            $.ajax({
                method: 'POST',
                url: 'server/jquery/employee_allocation.php',
                data: {
                    assetID: assetID,
                    formType: formID
                },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        var html = '';

                        if (data.message) {
                            html = "<tr><td colspan='6'>No assets found</td></tr>";
                        } else {
                            data.forEach(function (item) {
                                html += "<tr>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='assets_id' value='" + item.assets_id + "'><label>Assets ID</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='c_assets' value='" + item.assets + "'><label>Assets</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='brand' value='" + item.brand + "'><label>Brand</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='model' value='" + item.model + "'><label>Model</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='sn' value='" + item.sn + "'><label>Serial Number</label></div></td>";
                                html += "</tr>";
                            });
                        }
                        $("#showdata").html(html);
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

    // script for transferring pc
    $(document).ready(function () {
        $('#original_employee_id').on("change", function () {
            var transferID = $(this).val().trim();
            var formID = $(this).closest('form').attr('id');

            if (transferID === "") {
                $("#showdata").html("");
                return;
            }

            $.ajax({
                method: 'POST',
                url: 'server/jquery/transfer_allocation.php',
                data: {
                    transferID: transferID,
                    formType: formID
                },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        var html = '';

                        if (data.message) {
                            html = "<tr><td colspan='6'>No assets found</td></tr>";
                        } else {
                            data.forEach(function (item) {
                                html += "<tr>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='assets_id' value='" + item.assets_id + "'><label>Assets ID</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='c_assets' value='" + item.assets + "'><label>Assets</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='brand' value='" + item.brand + "'><label>Brand</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='model' value='" + item.model + "'><label>Model</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='sn' value='" + item.sn + "'><label>Serial Number</label></div></td>";
                                html += "</tr>";
                            });
                        }
                        $("#showdata").html(html);
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

    // script for returning pc
    $(document).ready(function () {
        $('#return_employee_id').on("change", function () {
            var returnID = $(this).val().trim();
            var formID = $(this).closest('form').attr('id');

            if (returnID === "") {
                $("#showdata").html("");
                return;
            }

            $.ajax({
                method: 'POST',
                url: 'server/jquery/return_allocations.php',
                data: {
                    returnID: returnID,
                    formType: formID
                },
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        var html = '';

                        if (data.message) {
                            html = "<tr><td colspan='6'>No assets found</td></tr>";
                        } else {
                            data.forEach(function (item) {
                                html += "<tr>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='assets_id' value='" + item.assets_id + "'><label>Assets ID</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='c_assets' value='" + item.assets + "'><label>Assets</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='brand' value='" + item.brand + "'><label>Brand</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='model' value='" + item.model + "'><label>Model</label></div></td>";
                                html += "<td class='p-4'><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='sn' value='" + item.sn + "'><label>Serial Number</label></div></td>";
                                html += "</tr>";
                            });
                        }
                        $("#showdata").html(html);
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

<?php
// // Display the results
// echo "<pre> TEST ";
// print_r($transferEmployeeID);
// echo "</pre>";


// echo "<pre> FROM ";
// print_r($transferEmployeeID);
// echo "</pre>";

// echo "<pre> TO ";
// print_r($transfer);
// echo "</pre>";


?>