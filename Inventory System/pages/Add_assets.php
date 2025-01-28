<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Assets</title>
</head>

<body>
    <div class="container my-5">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3>Add Assets</h3>
            </div>
            <form action="" method="post" id="addAssets">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" id="assets" name="assets" class="form-control">
                                <label for="assets">Assets</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" id="brand" name="brand" class="form-control">
                                <label for="brand">Brand</label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating">
                                <input type="text" id="model" name="model" class="form-control">
                                <label for="model">Model</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" id="sn" name="sn" class="form-control">
                                <label for="sn">Serial Number</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <button type="submit" name="addAssets" class="btn btn-dark">Submit</button>
                        <button type="reset" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>

<?php
if (isset($_POST['addAssets'])) {
    $assets = $_POST['assets'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $sn = $_POST['sn'];

    $assets_id = $assets . '_' . $sn;

    $store = "INSERT INTO assets (assets_id, assets, brand, model, sn) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($store);
    $stmt->bind_param("sssss", $assets_id, $assets, $brand, $model, $sn);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Assets saved successfully';
        echo "<script> window.location = 'index.php?page=add'; </script>";
        exit();
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to save assets. Please try again.';
        echo "<script> window.location = 'index.php?page=add'; </script>";
        exit();
    }
}
?>