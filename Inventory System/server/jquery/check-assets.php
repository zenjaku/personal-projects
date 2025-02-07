<?php
// Check if assets_id is provided
$assetsId = $_POST['assets_id'] ?? null;
if ($assetsId) {
    // Query to check if the asset is already used (motherboard, cpu, or gpu)
    $query = "
        SELECT assets_id 
        FROM computer 
        WHERE FIND_IN_SET('{$assetsId}', assets_id) > 0
    ";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Asset is already used on another computer
        echo json_encode(['canInstall' => false]);
    } else {
        // Asset is available to install
        echo json_encode(['canInstall' => true]);
    }
} else {
    echo json_encode(['canInstall' => false]);
}
?>
