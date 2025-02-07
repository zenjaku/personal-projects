<div class="container py-4 d-flex flex-column align-items-center" id="register">
    <div class="shadow-lg bg-white p-4 rounded-lg d-flex flex-column align-items-center">
        <h1 class="mb-5">REGISTER</h1>
        <form action="/register-employee" method="post" autocomplete="off" id="registerForm">
            <div class="row d-flex">
                <div class="col-2 form-floating">
                    <input type="text" id="employee_id" name="employee_id" class="form-control"
                        placeholder="Employee ID" required>
                    <label for="employee_id" class="employee-id"><small>Employee ID</small></label>
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
                    <input type="number" id="contact" name="contact" class="form-control w-100"
                        placeholder="Contact Number" required pattern="\d{11}" maxlength="11"
                        oninput="validateContact(this)">
                    <label for="contact">Contact Number</label>
                </div>
            </div>
            <div class="row d-flex my-3">
                <div class="col-md-4 col-sm-12 form-floating">
                    <input type="text" id="street" name="street" class="form-control w-100" placeholder="Street"
                        required>
                    <label for="street">Street</label>
                </div>
                <div class="col-md-4 col-sm-12 form-floating">
                    <input type="text" id="brgy" name="brgy" class="form-control w-100" placeholder="Barangay" required>
                    <label for="brgy">Barangay</label>
                </div>
                <div class="col-md-4 col-sm-12 form-floating">
                    <input type="number" id="zip" name="zip" class="form-control w-100" placeholder="Zip Code" required
                        maxlength="5" oninput="validateZip(this)">
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
                            NEW HIRE </option>
                        <option value="2">
                            WFH </option>
                        <option value="3">
                            TEMP WFH </option>
                    </select>
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn btn-dark" id="registerBtn" name="register">Submit</button>
                <button type="reset" class="btn btn-danger" onclick="parent.location.href=''">Cancel</button>
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

    document.addEventListener("DOMContentLoaded", () => {
        fetch("https://psgc.gitlab.io/api/regions/")
            .then((response) => response.json())
            .then((data) => {
                const regionSelect = document.getElementById("region");
                const provinceSelect = document.getElementById("province");
                const citySelect = document.getElementById("city");

                // Maps to store name-to-code mappings
                const regionMap = new Map(); // { regionName: regionCode }
                const provinceMap = new Map(); // { provinceName: provinceCode }
                const cityMap = new Map(); // { cityName: cityCode }

                // Populate regions dropdown
                data.forEach((region) => {
                    regionMap.set(region.name, region.code); // Store name-to-code mapping
                    const option = document.createElement("option");
                    option.value = region.name; // Save the name
                    option.textContent = region.name; // Display the name
                    regionSelect.appendChild(option);
                });

                // Region change event
                regionSelect.addEventListener("change", function () {
                    const regionName = this.value;
                    const regionCode = regionMap.get(regionName); // Get code from name

                    provinceSelect.innerHTML = '<option value="" selected>Select Province</option>';
                    citySelect.innerHTML = '<option value="" selected>Select Municipality/City</option>'; // Reset city select

                    if (regionCode === "130000000") {
                        // If NCR is selected, remove required from province
                        provinceSelect.removeAttribute("required");
                        provinceSelect.disabled = true; // Optionally disable the field
                    } else {
                        // If any other region is selected, add required back
                        provinceSelect.setAttribute("required", "required");
                        provinceSelect.disabled = false;
                    }

                    if (regionCode) {
                        Promise.all([
                            fetch(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`).then(res => res.json()),
                            regionCode === "130000000"
                                ? fetch(`https://psgc.gitlab.io/api/regions/${regionCode}/cities/`).then(res => res.json())
                                : Promise.resolve([]),
                        ])
                            .then(([provinces, cities]) => {
                                provinceMap.clear(); // Clear previous province mappings
                                provinces.forEach((province) => {
                                    provinceMap.set(province.name, province.code); // Store name-to-code mapping
                                    const option = document.createElement("option");
                                    option.value = province.name; // Save the name
                                    option.textContent = province.name; // Display the name
                                    provinceSelect.appendChild(option);
                                });

                                if (regionCode === "130000000") { // If NCR, populate cities
                                    cityMap.clear(); // Clear previous city mappings
                                    cities.forEach((city) => {
                                        cityMap.set(city.name, city.code); // Store name-to-code mapping
                                        const option = document.createElement("option");
                                        option.value = city.name; // Save the name
                                        option.textContent = city.name; // Display the name
                                        citySelect.appendChild(option);
                                    });
                                }
                            })
                            .catch((error) => console.error("Error fetching data:", error));
                    }
                });

                // Province change event
                provinceSelect.addEventListener("change", function () {
                    const provinceName = this.value;
                    const provinceCode = provinceMap.get(provinceName); // Get code from name
                    citySelect.innerHTML = '<option value="" selected>Select Municipality/City</option>';

                    if (provinceCode) {
                        fetch(`https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`)
                            .then(res => res.json())
                            .then(cities => {
                                cityMap.clear(); // Clear previous city mappings
                                cities.forEach((city) => {
                                    cityMap.set(city.name, city.code); // Store name-to-code mapping
                                    const option = document.createElement("option");
                                    option.value = city.name; // Save the name
                                    option.textContent = city.name; // Display the name
                                    citySelect.appendChild(option);
                                });
                            })
                            .catch(error => console.error("Error fetching cities:", error));
                    }
                });

                // // Form submission event
                // document.querySelector("form").addEventListener("submit", (event) => {
                //     event.preventDefault(); // Prevent default form submission

                //     // Get selected names
                //     const selectedRegionName = regionSelect.value;
                //     const selectedProvinceName = provinceSelect.value;
                //     const selectedCityName = citySelect.value;

                //     // Get corresponding codes from maps
                //     const selectedRegionCode = regionMap.get(selectedRegionName);
                //     const selectedProvinceCode = provinceMap.get(selectedProvinceName);
                //     const selectedCityCode = cityMap.get(selectedCityName);

                //     // Log or send data to backend
                //     console.log("Selected Names:", {
                //         region: selectedRegionName,
                //         province: selectedProvinceName,
                //         city: selectedCityName,
                //     });

                //     console.log("Corresponding Codes:", {
                //         region: selectedRegionCode,
                //         province: selectedProvinceCode,
                //         city: selectedCityCode,
                //     });

                //     // Example: Send data to backend
                //     // fetch("/your-backend-endpoint", {
                //     //     method: "POST",
                //     //     body: JSON.stringify({
                //     //         regionCode: selectedRegionCode,
                //     //         provinceCode: selectedProvinceCode,
                //     //         cityCode: selectedCityCode,
                //     //     }),
                //     // });
                // });
            })
            .catch((error) => console.error("Error fetching regions:", error));
    });

    // $(document).ready(function () {
    //     $('#employee_id').on('blur', function () {
    //         var employeeID = $(this).val();
    //         $.ajax({
    //             url: 'server/jquery/check_id.php',
    //             type: 'POST',
    //             data: { employee_id: employeeID },
    //             success: function (response) {
    //                 if (response.exists) {
    //                     alert('Employee id already exists');
    //                 }
    //             }
    //         });
    //     });
    // });
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
        var isEmployeeID = false; // Flag to track if the Employee ID is valid
        const submitBtn = document.getElementById('registerBtn'); // Ensure your submit button has this ID

        // Disable the submit button initially
        submitBtn.disabled = true;

        // Function to check if the Employee ID exists
        function checkID(employee_id) {
            $.ajax({
                method: 'POST',
                url: 'server/jquery/check_id.php', // Ensure this endpoint handles the check correctly
                data: { employee_id: employee_id },
                success: function (response) {
                    // Parse the JSON response from the server
                    var data = JSON.parse(response);
                    if (data.exists) {
                        showToast('Employee ID already exists. Please choose a different ID.', 'error');
                        isEmployeeID = false;
                    } else {
                        isEmployeeID = true;
                    }
                    // Enable or disable the button based on the result
                    submitBtn.disabled = !isEmployeeID;
                },
                error: function () {
                    showToast('Error checking Employee ID. Please try again.', 'error');
                    isEmployeeID = false;
                    submitBtn.disabled = true;
                }
            });
        }

        // Listen for input changes on the Employee ID field
        $('#employee_id').on('input', function () {
            var employee_id = $(this).val().trim();
            if (employee_id.length > 0) {
                // Pass the correct variable to checkID
                checkID(employee_id);
            } else {
                isEmployeeID = false;
                submitBtn.disabled = true; // Ensure the button remains disabled if the input is empty
            }
        });
    });




</script>