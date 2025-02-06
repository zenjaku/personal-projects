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
                <button type="submit" class="btn btn-dark" name="register">Submit</button>
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


</script>