<?php
require_once "server/allocate.php";
include 'admin/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocate</title>
</head>

<body>
    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                <h2>Allocation of Assets</h2>
            </div>
            <form action="server/store_allocate.php" method="post" class="d-flex flex-column" id="allocateForm">
                <div class="card-body my-5">
                    <div class="d-flex justify-content-center align-content-center gap-3">
                        <select name="employee_id" id="employee_id" class="form-select w-25" required>
                            <option value="Employee ID">Employee ID</option>
                            <?php while ($row = mysqli_fetch_assoc($employeeID)): ?>
                                <option value="<?= htmlspecialchars($row['employee_id']) ?>" <?= $row['employee_id'] === $id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['employee_id']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <select name="assets" id="assets" class="form-select w-25" required>
                            <option value="Assets">Assets</option>
                            <?php while ($row = mysqli_fetch_assoc($assetsResult)): ?>
                                <option id="assets_value" value="<?= htmlspecialchars($row['assets']) ?>"
                                    <?= $row['assets'] === $asset_name ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['assets']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <div class="form-floating">
                            <input type="text" name="sn" class="form-control" id="getAssets" required>
                            <label for="getAssets">Serial Number</label>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-4 py-4" id="inventoryDashboard">
                        <table class="table text-center">
                            <thead class="table-dark" id="showTitle">
                                <!-- <tr>
                                    <th scope="col">Assets ID</th>
                                    <th scope="col">Assets</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">S/N</th>
                                </tr> -->
                            </thead>
                            <tbody id="showdata">
                                <script>
                                    function matchAssets() {
                                        const assets = document.getElementById('assets');
                                        const getAssets = document.getElementById('getAssets'); // Dropdown of assets
                                        const confirmAssets = document.getElementById('c_assets');  // Asset displayed in the table
                                        const sn = document.getElementById('sn');

                                        if (!assets || !confirmAssets || !getAssets || !sn) return;

                                        console.log("Assets Value:", assets.value);
                                        console.log("Confirm Assets Value:", confirmAssets.value);
                                        console.log("S/N Value:", getAssets.value);
                                        console.log("Confirm S/N Value:", sn.value);

                                        if (getAssets.value !== sn.value) {
                                            sn.classList.add('text-white', 'bg-danger');
                                        } else {
                                            sn.classList.remove('text-white', 'bg-danger');
                                        }

                                        if (assets.value !== confirmAssets.value) {
                                            confirmAssets.classList.add('text-white', 'bg-danger');
                                        } else {
                                            confirmAssets.classList.remove('text-white', 'bg-danger');
                                        }
                                    }

                                    $(document).ready(function () {
                                        $('#getAssets').on("keyup", function () {
                                            var getAssets = $(this).val().trim();

                                            if (getAssets === "") {
                                                $("#showdata").html(""); // Clear the table when input is empty
                                                return;
                                            }

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
                                                                html += "<tr id='show'>";
                                                                html += "<td><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='assets_id' id='assets_id' value='" + item.assets_id + "'><label for='assets_id'>Assets ID</label></div></td>";
                                                                html += "<td><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='c_assets' id='c_assets' value='" + item.assets + "'><label for='c_assets'>Assets</label></div></td>";
                                                                html += "<td><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='brand' id='brand' value='" + item.brand + "'><label for='brand'>Brand</label></div></td>";
                                                                html += "<td><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='model' id='model' value='" + item.model + "'><label for='model'>Model</label></div></td>";
                                                                html += "<td><div class='form-floating'><input type='text' class='form-control input-fields' readonly name='sn' id='sn' value='" + item.sn + "'><label for='sn'>Serial Number</label></div></td>";
                                                                html += "</tr>";
                                                            });
                                                            $("#showdata").html(html); // Inject response into tbody
                                                            matchAssets(); // Validate the assets after updating the table
                                                        }
                                                    } catch (e) {
                                                        console.error("Error parsing JSON response", e);
                                                        $("#showdata").html("<tr><td colspan='5'>An error occurred while fetching data.</td></tr>");
                                                    }
                                                },
                                                error: function () {
                                                    $("#showdata").html("<tr><td colspan='5'>An error occurred while fetching data.</td></tr>");
                                                }
                                            });
                                        });

                                        $('#assets').on('change', function () {
                                            matchAssets(); // Validate the assets when the dropdown value changes
                                        });
                                    });
                                </script>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end gap-3">
                    <button type="submit" name="allocate" class="btn btn-dark">Submit</button>
                    <button type="reset" class="btn btn-danger" onclick="parent.location.href=''">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>