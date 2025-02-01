<div class="container py-4 d-flex flex-column align-items-center" id="register">
    <div class="shadow-lg bg-white p-4 rounded-lg d-flex flex-column align-items-center">
        <h1 class="mb-5">REGISTER</h1>
        <form action="/register-employee" method="post" autocomplete="off" id="registerForm">
            <div class="row d-flex my-3">
                <div class="col-2 form-floating">
                    <input type="text" id="employee_id" name="employee_id" class="form-control" placeholder="Employee ID" required>
                    <label for="employee_id" class="employee-id"><small >Employee ID</small></label>
                </div>
                <div class="col-5 form-floating">
                    <input type="text" id="fname" name="fname" class="form-control" placeholder="First Name" required>
                    <label for="fname">First Name</label>
                </div>
                <div class="col-5 form-floating">
                    <input type="text" id="lname" name="lname" class="form-control" placeholder="Last Name" required>
                    <label for="lname">Last Name</label>
                </div>
            </div>
            <div class="row d-flex my-3 gap-3">
                <div class="col-md-12 form-floating">
                    <input type="number" id="contact" name="contact" class="form-control w-100" placeholder="Contact Number" required
                        pattern="\d{11}" maxlength="11" oninput="validateContact(this)">
                    <label for="contact">Contact Number</label>
                </div>
            </div>
            <div class="row d-flex my-3">
                <div class="col-md-4 col-sm-12 form-floating">
                    <input type="text" id="street" name="street" class="form-control w-100" placeholder="Street" required>
                    <label for="street">Street</label>
                </div>
                <div class="col-md-4 col-sm-12 form-floating">
                    <input type="text" id="brgy" name="brgy" class="form-control w-100" placeholder="Barangay" required>
                    <label for="brgy">Barangay</label>
                </div>
                <div class="col-md-4 col-sm-12 form-floating">
                    <input type="number" id="zip" name="zip" class="form-control w-100" placeholder="Zip Code" required maxlength="5"
                        oninput="validateZip(this)">
                    <label for="zip">Zip Code</label>
                </div>
            </div>
            <div class="row d-flex my-3">
                <div class="col-md-4 col-sm-12 form-floating">
                    <select id="region" name="region" class="form-control" required>
                        <option readonly>Select Region</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12 form-floating">
                    <select id="province" name="province" class="form-control" required>
                        <option readonly>Select Province</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12 form-floating">
                    <select id="city" name="city" class="form-control" required>
                        <option readonly>Select Municipality/City</option>
                    </select>
                </div>
            </div>


            <div class="row d-flex my-3">
                <div class="col-md-12 form-floating">
                    <select type="text" id="status" name="status" class="form-control" required>
                        <option class="bg-secondary-subtle" readonly>Work Status</option>
                        <option value="1">
                            WFH </option>
                        <option value="2">
                            On-site </option>
                        <option value="3">
                            Resigned </option>
                    </select>
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn btn-dark" name="register">Submit</button>
                <button type="button" class="btn btn-danger" onclick="parent.location.href=''">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function validateZip(input) {
        if (input.value.length > 5) {
            input.value = input.value.slice(0, 5);
        }
    }
    function validateContact(input) {
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11);
        }
    }

    function validateAge(input) {
        if (input.value < 0) {
            input.value = '';
        }
    }

    //jquery
    $(document).ready(function () {
        // Load regions on page load
        $.ajax({
            method: 'POST',
            url: 'server/jquery/locations.php',
            data: { action: 'getRegions' },
            success: function (response) {
                var data = JSON.parse(response);
                var options = '<option readonly>Select Region</option>';
                data.forEach(function (item) {
                    options += `<option value="${item.region_c}">${item.region_m}</option>`;
                });
                $("#region").html(options);
            }
        });

        // When a region is selected, fetch provinces
        $('#region').on('change', function () {
            var region_code = $(this).val();

            if (region_code) {
                $.ajax({
                    method: 'POST',
                    url: 'server/jquery/locations.php',
                    data: { action: 'getProvinces', region_code: region_code },
                    success: function (response) {
                        var data = JSON.parse(response);
                        var options = '<option readonly>Select Province</option>';
                        data.forEach(function (item) {
                            options += `<option value="${item.province_c}">${item.province_m}</option>`;
                        });
                        $("#province").html(options);
                        $("#city").html('<option readonly>Select Municipality/City</option>'); // Reset city dropdown
                    }
                });
            }
        });

        // When a province is selected, fetch cities
        $('#province').on('change', function () {
            var province_code = $(this).val();

            if (province_code) {
                $.ajax({
                    method: 'POST',
                    url: 'server/jquery/locations.php',
                    data: { action: 'getCities', province_code: province_code },
                    success: function (response) {
                        var data = JSON.parse(response);
                        var options = '<option readonly>Select Municipality/City</option>';
                        data.forEach(function (item) {
                            options += `<option value="${item.citymun_c}">${item.citymun_m}</option>`;
                        });
                        $("#city").html(options);
                    }
                });
            }
        });
    });
</script>