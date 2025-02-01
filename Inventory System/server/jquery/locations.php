<?php
include '../connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'getRegions') {
        $query = "SELECT * FROM tblregion ORDER BY region_m ASC";
        $result = mysqli_query($conn, $query);

        $regions = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $regions[] = $row;
        }
        echo json_encode($regions);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'getProvinces' && isset($_POST['region_code'])) {
        $region_code = $_POST['region_code'];

        $query = "SELECT * FROM tblprovince WHERE region_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $region_code);
        $stmt->execute();
        $result = $stmt->get_result();

        $provinces = [];
        while ($row = $result->fetch_assoc()) {
            $provinces[] = $row;
        }
        echo json_encode($provinces);
    }

    if (isset($_POST['action']) && $_POST['action'] === 'getCities' && isset($_POST['province_code'])) {
        $province_code = $_POST['province_code'];

        $query = "SELECT * FROM tblcitymun WHERE province_c = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $province_code);
        $stmt->execute();
        $result = $stmt->get_result();

        $cities = [];
        while ($row = $result->fetch_assoc()) {
            $cities[] = $row;
        }
        echo json_encode($cities);
    }
}
?>
