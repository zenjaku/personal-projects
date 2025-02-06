<?php

$regions = [];
$provinces = [];
$cities = [];

$fetchRegion = "SELECT * FROM tblregion ORDER BY region_m ASC";
$searchRegion = mysqli_query($conn, $fetchRegion);
while ($region = mysqli_fetch_assoc($searchRegion)) {
    $regions[] = $region;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['region']) && !isset($_POST['register'])) {
        $region = $_POST['region'];
        $query = "SELECT * FROM tblprovince WHERE region_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $region);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $provinces[] = $row;
        }
    }

    if (isset($_POST['province']) && !isset($_POST['register'])) {
        $province = $_POST['province'];
        $query = "SELECT * FROM tblcitymun WHERE province_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $province);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $cities[] = $row;
        }
    }

    if (isset($_POST['register'])) {
        // Handle the final registration logic here
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $dob = $_POST['dob'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $contact = $_POST['contact'];
        $street = $_POST['street'];
        $brgy = $_POST['brgy'];
        $zip = $_POST['zip'];
        $region = $_POST['region'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $status = $_POST['status'];

        // Fetch the names based on the selected codes
        $query = "SELECT region_m FROM tblregion WHERE region_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $region);
        $stmt->execute();
        $stmt->bind_result($region_name);
        $stmt->fetch();
        $stmt->close();

        $query = "SELECT province_m FROM tblprovince WHERE province_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $province);
        $stmt->execute();
        $stmt->bind_result($province_name);
        $stmt->fetch();
        $stmt->close();

        $query = "SELECT citymun_m FROM tblcitymun WHERE citymun_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $city);
        $stmt->execute();
        $stmt->bind_result($city_name);
        $stmt->fetch();
        $stmt->close();

        // Insert the user data into the database
        $query = "INSERT INTO data_table (fname, lname, dob, age, sex, contact, street, brgy, zip, region, province, city, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssissssissss", $fname, $lname, $dob, $age, $sex, $contact, $street, $brgy, $zip, $region_name, $province_name, $city_name, $status);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = 'Information saved successfully';
            header("Location: index.php?page=home");
            exit();
        } else {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Failed to save information. Please try again.';
            header("Location: index.php?page=register");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <div class="container py-5 d-flex flex-column align-items-center" id="register">
        <div class="shadow-lg p-4 rounded-lg d-flex flex-column align-items-center">
            <h1 class="mb-5">DATA INFORMATION</h1>
            <form action="" method="post" autocomplete="off" id="registerForm">
                <input type="hidden" name="fname" value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
                <input type="hidden" name="lname" value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
                <input type="hidden" name="dob" value="<?php echo isset($_POST['dob']) ? $_POST['dob'] : ''; ?>">
                <input type="hidden" name="age" value="<?php echo isset($_POST['age']) ? $_POST['age'] : ''; ?>">
                <input type="hidden" name="sex" value="<?php echo isset($_POST['sex']) ? $_POST['sex'] : ''; ?>">
                <input type="hidden" name="contact" value="<?php echo isset($_POST['contact']) ? $_POST['contact'] : ''; ?>">
                <input type="hidden" name="street" value="<?php echo isset($_POST['street']) ? $_POST['street'] : ''; ?>">
                <input type="hidden" name="brgy" value="<?php echo isset($_POST['brgy']) ? $_POST['brgy'] : ''; ?>">
                <input type="hidden" name="zip" value="<?php echo isset($_POST['zip']) ? $_POST['zip'] : ''; ?>">

                <div class="row d-flex my-3">
                    <div class="col-md-6 col-sm-12 form-floating">
                        <input type="text" id="fname" name="fname" class="form-control" required value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>">
                        <label for="fname">First Name</label>
                    </div>
                    <div class="col-md-6 col-sm-12 form-floating">
                        <input type="text" id="lname" name="lname" class="form-control" required value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>">
                        <label for="lname">Last Name</label>
                    </div>
                </div>
                <div class="row d-flex my-3">
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
                </div>
                <div class="row d-flex my-3 gap-3">
                    <div class="col-md-12 form-floating">
                        <input type="number" id="contact" name="contact" class="form-control w-100" required pattern="\d{11}" maxlength="11" oninput="validateContact(this)" value="<?php echo isset($_POST['contact']) ? $_POST['contact'] : ''; ?>">
                        <label for="contact">Contact Number</label>
                    </div>
                </div>
                <div class="row d-flex my-3">
                    <div class="col-md-4 col-sm-12 form-floating">
                        <input type="text" id="street" name="street" class="form-control w-100" required value="<?php echo isset($_POST['street']) ? $_POST['street'] : ''; ?>">
                        <label for="street">Street</label>
                    </div>
                    <div class="col-md-4 col-sm-12 form-floating">
                        <input type="text" id="brgy" name="brgy" class="form-control w-100" required value="<?php echo isset($_POST['brgy']) ? $_POST['brgy'] : ''; ?>">
                        <label for="brgy">Barangay</label>
                    </div>
                    <div class="col-md-4 col-sm-12 form-floating">
                        <input type="text" id="zip" name="zip" class="form-control w-100" required maxlength="5" oninput="validateZip(this)" value="<?php echo isset($_POST['zip']) ? $_POST['zip'] : ''; ?>">
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
                        <select id="province" name="province" class="form-control" required onchange="this.form.submit()">
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
                            <option class="bg-secondary-subtle" readonly> Status</option>
                            <option value="1" <?php echo (isset($_POST['status']) && $_POST['status'] == '1') ? 'selected' : ''; ?>> Under Investigation </option>
                            <option value="2" <?php echo (isset($_POST['status']) && $_POST['status'] == '2') ? 'selected' : ''; ?>> Surrendered </option>
                            <option value="3" <?php echo (isset($_POST['status']) && $_POST['status'] == '3') ? 'selected' : ''; ?>> Apprehended </option>
                            <option value="4" <?php echo (isset($_POST['status']) && $_POST['status'] == '4') ? 'selected' : ''; ?>> Escaped </option>
                            <option value="5" <?php echo (isset($_POST['status']) && $_POST['status'] == '5') ? 'selected' : ''; ?>> Deceased </option>
                        </select>
                    </div>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary" name="register">Submit</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
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