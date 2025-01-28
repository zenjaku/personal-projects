<?php
include_once 'server/register.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <div class="container py-4 d-flex flex-column align-items-center" id="register">
        <div class="shadow-lg p-4 rounded-lg d-flex flex-column align-items-center">
            <h1 class="mb-5">REGISTER</h1>
            <form action="" method="post" autocomplete="off" id="registerForm">
                <input type="hidden" name="employee_id" value="<?php echo isset($_POST['employee_id']) ? $_POST['employee_id'] : ''; ?>">
                <input type="hidden" name="fname" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
                <input type="hidden" name="lname" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
                <input type="hidden" name="contact"
                    value="<?php echo isset($_POST['contact']) ? $_POST['contact'] : ''; ?>">
                <input type="hidden" name="street"
                    value="<?php echo isset($_POST['street']) ? $_POST['street'] : ''; ?>">
                <input type="hidden" name="brgy" value="<?php echo isset($_POST['brgy']) ? $_POST['brgy'] : ''; ?>">
                <input type="hidden" name="zip" value="<?php echo isset($_POST['zip']) ? $_POST['zip'] : ''; ?>">

                <div class="row d-flex my-3">
                    <div class="col-2 form-floating">
                        <input type="number" id="employee_id" name="employee_id" class="form-control" required
                            value="<?php echo isset($_POST['employee_id']) ? $_POST['employee_id'] : ''; ?>">
                        <label for="employee_id">Employee ID</label>
                    </div>
                    <div class="col-5 form-floating">
                        <input type="text" id="fname" name="fname" class="form-control" required
                            value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
                        <label for="fname">First Name</label>
                    </div>
                    <div class="col-5 form-floating">
                        <input type="text" id="lname" name="lname" class="form-control" required
                            value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
                        <label for="lname">Last Name</label>
                    </div>
                </div>
                <!-- <div class="row d-flex my-3">
                    <div class="col-12 form-floating">
                        <input type="date" id="dob" name="dob" class="form-control w-100" required value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>">
                        <label for="dob">Date of Birth</label>
                    </div>
                </div>
                <div class="row d-flex my-3">
                    <div class="col-md-6 col-sm-12 form-floating">
                        <input type="number" id="age" name="age" class="form-control" required oninput="validateAge(this)" value="<?php echo isset($_POST['age']) ? $_POST['age'] : ''; ?>">
                        <label for="age">Age</label>
                    </div>
                    <div class="col-md-6 col-sm-12 form-floating">
                        <select type="text" id="sex" name="sex" class="form-control" required>
                            <option class="bg-secondary-subtle" readonly> Select Sex</option>
                            <option value="Male" <?php echo (isset($_POST['sex']) && $_POST['sex'] == 'Male') ? 'selected' : ''; ?>> Male </option>
                            <option value="Female" <?php echo (isset($_POST['sex']) && $_POST['sex'] == 'Female') ? 'selected' : ''; ?>> Female </option>
                        </select>
                    </div>
                </div> -->
                <div class="row d-flex my-3 gap-3">
                    <div class="col-md-12 form-floating">
                        <input type="number" id="contact" name="contact" class="form-control w-100" required
                            pattern="\d{11}" maxlength="11" oninput="validateContact(this)"
                            value="<?php echo isset($_POST['contact']) ? $_POST['contact'] : ''; ?>">
                        <label for="contact">Contact Number</label>
                    </div>
                </div>
                <div class="row d-flex my-3">
                    <div class="col-md-4 col-sm-12 form-floating">
                        <input type="text" id="street" name="street" class="form-control w-100" required
                            value="<?php echo isset($_POST['street']) ? $_POST['street'] : ''; ?>">
                        <label for="street">Street</label>
                    </div>
                    <div class="col-md-4 col-sm-12 form-floating">
                        <input type="text" id="brgy" name="brgy" class="form-control w-100" required
                            value="<?php echo isset($_POST['brgy']) ? $_POST['brgy'] : ''; ?>">
                        <label for="brgy">Barangay</label>
                    </div>
                    <div class="col-md-4 col-sm-12 form-floating">
                        <input type="text" id="zip" name="zip" class="form-control w-100" required maxlength="5"
                            oninput="validateZip(this)"
                            value="<?php echo isset($_POST['zip']) ? $_POST['zip'] : ''; ?>">
                        <label for="zip">Zip Code</label>
                    </div>
                </div>
                <div class="row d-flex my-3">
                    <div class="col-md-4 col-sm-12 form-floating">
                        <select id="region" name="region" class="form-control" required onchange="this.form.submit()">
                            <option readonly>Select Region</option>
                            <?php
                            foreach ($regions as $region) {
                                $selected = isset($_POST['region']) && $_POST['region'] == $region['region_c'] ? 'selected' : '';
                                echo "<option value='{$region['region_c']}' $selected>{$region['region_m']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 form-floating">
                        <select id="province" name="province" class="form-control" required
                            onchange="this.form.submit()">
                            <option readonly>Select Province</option>
                            <?php
                            foreach ($provinces as $province) {
                                $selected = isset($_POST['province']) && $_POST['province'] == $province['province_c'] ? 'selected' : '';
                                echo "<option value='{$province['province_c']}' $selected>{$province['province_m']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 form-floating">
                        <select id="city" name="city" class="form-control" required>
                            <option readonly>Select Municipality/City</option>
                            <?php
                            foreach ($cities as $city) {
                                echo "<option value='{$city['citymun_c']}'>{$city['citymun_m']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row d-flex my-3">
                    <div class="col-md-12 form-floating">
                        <select type="text" id="status" name="status" class="form-control" required>
                            <option class="bg-secondary-subtle" readonly>Work Status</option>
                            <option value="1" <?= (isset($_POST['status']) && $_POST['status'] == '1') ? 'selected' : ''; ?>> WFH </option>
                            <option value="2" <?= (isset($_POST['status']) && $_POST['status'] == '2') ? 'selected' : ''; ?>> On-site </option>
                            <option value="3" <?= (isset($_POST['status']) && $_POST['status'] == '3') ? 'selected' : ''; ?>> Resigned </option>
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
    </script>
</body>

</html>