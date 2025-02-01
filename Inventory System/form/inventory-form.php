<?php

if (isset($_POST['addAssets'])) {
    $assets = $_POST['assets'];  // Array
    $brands = $_POST['brand'];  // Array
    $models = $_POST['model'];  // Array
    $sns = $_POST['sn'];  // Array

    $created_at = date('Y-m-d H:i:s'); // Store current date & time

    // Prepare the statement for inserting assets
    $store = "INSERT INTO assets (assets_id, assets, brand, model, sn, created_at) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($store);

    if (!$stmt) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Database error: ' . $conn->error;
        echo "<script> window.location = '/add'; </script>";
        exit();
    }

    // Loop through each set of inputs
    for ($i = 0; $i < count($assets); $i++) {
        $assetName = $assets[$i];
        $brandName = $brands[$i];
        $modelName = $models[$i];
        $serialNumber = $sns[$i];
        // Use the same $created_at value for all assets
        $createdAt = $created_at;

        // Unique asset ID
        $assets_id = $assetName . '_' . $serialNumber;

        // Bind parameters for each row
        $stmt->bind_param("ssssss", $assets_id, $assetName, $brandName, $modelName, $serialNumber, $createdAt);
        $stmt->execute();  // Execute the statement
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    $_SESSION['status'] = 'success';
    $_SESSION['success'] = 'Assets saved successfully';
    echo "<script> window.location = '/add'; </script>";
    exit();
}

?>