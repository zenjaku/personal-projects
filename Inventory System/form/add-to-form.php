<?php
// Fetch Computer Specifications
if (isset($_GET['assets_id']) && !empty($_GET['assets_id'])) {
    $assets_id = $_GET['assets_id'];

    $fetchSpecs = $conn->prepare("SELECT * FROM assets WHERE assets_id = ? ");
    $fetchSpecs->bind_param("s", $assets_id);
    $fetchSpecs->execute();
    $result = $fetchSpecs->get_result();

    // Fetch all rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    echo "<pre>";
    print_r($rows);
    echo "</pre>";

}
?>