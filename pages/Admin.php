<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenrose Co.</title>
</head>

<body>
    <section id="adminPanel" class="container mt-5">
        <?php
        if (isset($_SESSION['status'])) {
            if ($_SESSION['status'] === 'saved') {
                ?>
                <div class="alert bg-warning alert-dismissible fade show" role="alert" id="alertSaved">
                    <strong><?php echo $_SESSION['saved']; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>
                    setTimeout(function () {
                        const alertTimeOut = document.getElementById('alertSaved');
                        const alert = new bootstrap.Alert(alertTimeOut);
                        alert.close();

                    }, 3000);
                </script>

                <?php
                unset($_SESSION['status']);
            } elseif ($_SESSION['status'] === 'failedSaved') {
                ?>
                <div class="alert bg-danger alert-dismissible fade show" role="alert" id="alertFailed">
                    <strong><?php echo $_SESSION['failedSaved']; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>
                    setTimeout(function () {
                        const alertTimeOut = document.getElementById('alertFailed');
                        const alert = new bootstrap.Alert(alertTimeOut);
                        alert.close();

                    }, 3000);
                </script>
                <?php
                unset($_SESSION['status']); // Clear the session variable
            }
        }
        ?>
        <div class="row">
            <h1>ADMIN PANEL</h1>
            <hr />
            <div class="col-md-2 col-sm-12">
                <div class="row mt-5 d-flex flex-column gap-2">
                    <div class="col">
                        <button type="button" id="modal" class="btn btn-warning w-100" data-bs-toggle="modal"
                            data-bs-target="#addModal">Add Product</button>
                    </div>
                    <div class="col">
                        <button type="button" id="modal" class="btn btn-dark w-100">Clients Account</button>
                    </div>
                    <div class="col">
                        <button type="button" id="modal" class="btn btn-primary w-100">List of Orders</button>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-sm-12">
                <div class="row p-3 align-items-center border mt-4">
                    <div class="col-md-3 col-sm-12">
                        <div class="cart-img">
                            <img src="assets/p_img2.png" alt="p_img1.png" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="cart-product flex-column">
                            <p class="lead">Men Round Neck Pure Cotton T-shirt</p>
                            <p>Small, Medium</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="price">
                            <p class="lead fw-bold">PHP 200.00</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-12 d-flex justify-content-end">
                        <form id="cartForm" action="" method="POST" autocomplete="off">
                            <div class="btn-container d-flex flex-row gap-2">
                                <button class="btn btn-dark" id="saveBtn" name="EDIT">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn bg-danger text-white" id="deleteBtn" name="DELETE">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--add product modal-->
    <section id="add product">
        <div class="modal fade justify-content-center align-content-center" id="addModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h4>ADD A PRODUCT</h4>
                    </div>
                    <form id="addForm" class="form" action="server/add.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="mb-3 d-flex justify-content-center gap-3">
                                <label for="file-upload-1" class="custom-file-upload">
                                    <img src="assets/image-alt.svg" alt="Upload Icon" id="upload-preview-1"
                                        class="previewImg" />
                                </label>
                                <input type="file" name="images[]" id="file-upload-1" class="file-input"
                                    accept="image/*" onchange="previewImage(event, 1)" />

                                <label for="file-upload-2" class="custom-file-upload">
                                    <img src="assets/image-alt.svg" alt="Upload Icon" id="upload-preview-2"
                                        class="previewImg" />
                                </label>
                                <input type="file" name="images[]" id="file-upload-2" class="file-input"
                                    accept="image/*" onchange="previewImage(event, 2)" />

                                <label for="file-upload-3" class="custom-file-upload">
                                    <img src="assets/image-alt.svg" alt="Upload Icon" id="upload-preview-3"
                                        class="previewImg" />
                                </label>
                                <input type="file" name="images[]" id="file-upload-3" class="file-input"
                                    accept="image/*" onchange="previewImage(event, 3)" />

                                <label for="file-upload-4" class="custom-file-upload">
                                    <img src="assets/image-alt.svg" alt="Upload Icon" id="upload-preview-4"
                                        class="previewImg" />
                                </label>
                                <input type="file" name="images[]" id="file-upload-4" class="file-input"
                                    accept="image/*" onchange="previewImage(event, 4)" />
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="productName" name="productName"
                                    placeholder="Product Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="description" name="description"
                                    placeholder="Description" required>
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="PHP 200.00" required>
                            </div>
                            <div class="mb-3">
                                <input type="radio" class="btn-check" id="top" name="sub" autocomplete="off"
                                    value="Top wear">
                                <label class="btn btn-outline-dark" for="top">Top wear</label>
                                <input type="radio" class="btn-check" id="bottom" name="sub" autocomplete="off"
                                    value="Bottom wear">
                                <label class="btn btn-outline-dark" for="bottom">Bottom wear</label>
                            </div>
                            <div class="mb-3">
                                <input type="radio" class="btn-check" id="men" name="category" autocomplete="off"
                                    value="Men">
                                <label class="btn btn-outline-dark" for="men">Men</label>
                                <input type="radio" class="btn-check" id="women" name="category" autocomplete="off"
                                    value="Women">
                                <label class="btn btn-outline-dark" for="women">Women</label>
                                <input type="radio" class="btn-check" id="kids" name="category" autocomplete="off"
                                    value="Kids">
                                <label class="btn btn-outline-dark" for="kids">Kids</label>
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" class="btn-check" id="small" name="sizes[]" autocomplete="off"
                                    value="Small">
                                <label class="btn btn-outline-dark" for="small">Small</label>
                                <input type="checkbox" class="btn-check" id="medium" name="sizes[]" autocomplete="off"
                                    value="Medium">
                                <label class="btn btn-outline-dark" for="medium">Medium</label>
                                <input type="checkbox" class="btn-check" id="large" name="sizes[]" autocomplete="off"
                                    value="Large">
                                <label class="btn btn-outline-dark" for="large">Large</label>
                                <input type="checkbox" class="btn-check" id="xl" name="sizes[]" autocomplete="off"
                                    value="XL">
                                <label class="btn btn-outline-dark" for="xl">XL</label>
                                <input type="checkbox" class="btn-check" id="2xl" name="sizes[]" autocomplete="off"
                                    value="2XL">
                                <label class="btn btn-outline-dark" for="2xl">2XL</label>
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="bestSeller">Best Seller</label>
                                    <input class="form-check-input" type="checkbox" role="switch" id="bestSeller"
                                        name="bestSellerSwitch">
                                    <input type="hidden" name="bestSeller" id="bestSellerValue" value="false">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning" name="SUBMIT">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!--clients account modal-->

    <!--List of orders modal-->

</body>
<script>
    // Store selected file names to track duplicates
    let selectedFiles = [];

    function previewImage(event, id) {
        const input = event.target;
        const preview = document.getElementById(`upload-preview-${id}`);

        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Check for duplicates
            if (isDuplicate(file)) {
                alert("You have already selected this image. Please choose another one.");
                input.value = ""; // Clear the input to prevent duplicate selection
                return;
            }

            // Add the selected file name to the list
            selectedFiles.push(file.name);

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result; // Set the preview image
            };
            reader.readAsDataURL(file); // Read the image file
        }
    }

    function isDuplicate(file) {
        return selectedFiles.includes(file.name); // Check for duplicates
    }

    function resetSelectedFiles() {
        selectedFiles = []; // Clear the selected files
    }

    document.getElementById("bestSeller").addEventListener("change", function () {
        document.getElementById("bestSellerValue").value = this.checked ? "true" : "false";
    });

</script>

</html>