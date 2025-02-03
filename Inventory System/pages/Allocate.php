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
                        <div class="d-flex flex-column justify-content-center align-content-center gap-3">
                            <select name="employee_id" id="allocate_employee_id" class="form-select" required>
                                <option value="">Employee ID</option>
                                <?php foreach ($employeeIDs as $row): ?>
                                    <option value="<?= htmlspecialchars($row['employee_id']) ?>">
                                        <?= htmlspecialchars($row['employee_id']) ?>
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
                        <div class="d-flex flex-column justify-content-center align-content-center gap-3">
                            <label for="transfer_employee_id"> From </label>
                            <select name="employee_id" id="transfer_employee_id" class="form-select" required>
                                <option value="">Employee ID</option>
                                <?php foreach ($transferEmployeeID as $row): ?>
                                    <option value="<?= htmlspecialchars($row['employee_id']) ?>">
                                        <?= htmlspecialchars($row['employee_id']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <label for="transfer_employee_id"> To </label>
                            <select name="transfer_employee_id" id="transfer_employee_id"
                                class="form-select computer-select" required>
                                <option value="">Employee ID</option>
                                <?php foreach ($transfer as $row): ?>
                                    <option value="<?= htmlspecialchars($row['employee_id']) ?>">
                                        <?= htmlspecialchars($row['employee_id']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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
                        <div class="d-flex flex-column justify-content-center align-content-center gap-3">
                            <select name="employee_id" id="return_employee_id" class="form-select" required>
                                <option value="">Employee ID</option>
                                <?php foreach ($transferEmployeeID as $row): ?>
                                    <option value="<?= htmlspecialchars($row['employee_id']) ?>">
                                        <?= htmlspecialchars($row['employee_id']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
<!-- 
                            <select name="cname_id" id="return_cname_id" class="form-select computer-select" required>
                                <option value="">Select a Computer</option>
                                <?php foreach ($assets as $row): ?>
                                    <option value="<?= htmlspecialchars($row['cname_id']) ?>">
                                        <?= htmlspecialchars($row['cname']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select> -->
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
        const allocateForm = document.getElementById("allocateForm");
        const transferForm = document.getElementById("transferForm");
        const returnForm = document.getElementById("returnForm");
        const showData = document.getElementById("showdata");
        const resetButtons = document.querySelectorAll(".resetForm"); // Selects all buttons with the class 'resetForm'

        // Loop through all reset buttons and add event listener
        resetButtons.forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault(); // Prevent default reset behavior

                // Reset form fields
                allocateForm.reset();
                transferForm.reset();
                returnForm.reset();

                // Clear dynamically populated data
                showData.innerHTML = "";
            });
        });
    });
</script>
<script>
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
        $('#transfer_employee_id').on("change", function () {
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