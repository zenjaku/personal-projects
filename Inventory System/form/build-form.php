<?php
if (isset($_POST['build-pc'])) {
    $cname = $_POST['cname'];  // Single value (not an array)
    $assets_id = $_POST['assets_id'];  // Array of asset IDs

    $created_at = date('Y-m-d H:i:s');

    $cname_id = $cname . '_' . $created_at;

    // Prepare the statement
    $store = "INSERT INTO computer (cname_id, cname, assets_id, created_at) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($store);

    if (!$stmt) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Database error: ' . $conn->error;
        echo "<script> window.location = '/build'; </script>";
        exit();
    }

    // Loop through ALL ASSETS
    foreach ($assets_id as $assetId) {
        $stmt->bind_param("ssss", $cname_id, $cname, $assetId, $created_at);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    $_SESSION['status'] = 'success';
    $_SESSION['success'] = 'Assets saved successfully';
    echo "<script> window.location = '/build'; </script>";
    exit();
}
?>