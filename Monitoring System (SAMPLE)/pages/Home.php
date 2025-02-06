<?php

$searchQuery = $_GET['searchQuery'] ?? '';
$region = $_GET['region'] ?? '';
$province = $_GET['province'] ?? '';
$city = $_GET['city'] ?? '';

$searchQuery = mysqli_real_escape_string($conn, $searchQuery);
$region = mysqli_real_escape_string($conn, $region);
$province = mysqli_real_escape_string($conn, $province);
$city = mysqli_real_escape_string($conn, $city);

$regions = mysqli_query($conn, "SELECT DISTINCT region FROM data_table ORDER BY region");
$provinces = mysqli_query($conn, "SELECT DISTINCT province FROM data_table ORDER BY province");
$cities = mysqli_query($conn, "SELECT DISTINCT city FROM data_table ORDER BY city");

$fetchData = "SELECT * FROM data_table WHERE 1";

if (!empty($searchQuery)) {
    $searchTerms = explode(' ', $searchQuery);
    $conditions = [];
    foreach ($searchTerms as $term) {
        $conditions[] = "fname LIKE '%$term%'";
        $conditions[] = "lname LIKE '%$term%'";
        $conditions[] = "dob LIKE '%$term%'";
    }
    $fetchData .= " AND (" . implode(' OR ', $conditions) . ")";
}

if (!empty($region) && $region !== '--Select Region--') {
    $fetchData .= " AND region = '$region'";
}
if (!empty($province) && $province !== '--Select Province--') {
    $fetchData .= " AND province = '$province'";
}
if (!empty($city) && $city !== '--Select City/Municipality--') {
    $fetchData .= " AND city = '$city'";
}

$searchResult = mysqli_query($conn, $fetchData);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <div class="container my-5">
        <div class="row d-flex mb-3">
            <div class="col-md-3 col-sm-12">
                <h1>DATA CHART</h1>
            </div>
            <div class="col-md-8 col-sm-12">
                <form action="" method="get" class="d-flex gap-3">

                    <select class="form-control" name="region" id="region" style="cursor: pointer;">
                        <option value="--Select Region--">--Select Region--</option>
                        <?php while ($row = mysqli_fetch_assoc($regions)): ?>
                            <option value="<?= htmlspecialchars($row['region']) ?>" <?= $row['region'] === $region ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['region']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <select class="form-control" name="province" id="province" style="cursor: pointer;">
                        <option value="--Select Province--">--Select Province--</option>
                        <?php while ($row = mysqli_fetch_assoc($provinces)): ?>
                            <option value="<?= htmlspecialchars($row['province']) ?>" <?= $row['province'] === $province ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['province']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <select class="form-control" name="city" id="city" style="cursor: pointer;">
                        <option value="--Select City/Municipality--">--Select City/Municipality--</option>
                        <?php while ($row = mysqli_fetch_assoc($cities)): ?>
                            <option value="<?= htmlspecialchars($row['city']) ?>" <?= $row['city'] === $city ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['city']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <input type="text" name="searchQuery" class="form-control" placeholder="Search Bar"
                        value="<?= htmlspecialchars($searchQuery) ?>">

                    <button type="submit" name="search" class="btn btn-warning h-50">Search</button>
                </form>
            </div>
            <div class="col-1">
                <button id="resetBtn" class="btn btn-danger h-50">Reset</button>
            </div>
        </div>
        <?php if (mysqli_num_rows($searchResult) > 0): ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Age</th>
                            <th scope="col">Date of Birth</th>
                            <th scope="col">Sex</th>
                            <th scope="col">Contact</th>
                            <th scope="col">Address</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($result = mysqli_fetch_assoc($searchResult)): ?>
                            <tr>
                                <td><?= $result['fname'] . ' ' . $result['lname'] ?></td>
                                <td><?= $result['age'] ?></td>
                                <td><?= $result['dob'] ?></td>
                                <td><?= $result['sex'] ?></td>
                                <td><?= $result['contact'] ?></td>
                                <td><?= $result['street'] . ' ' . $result['brgy'] . ' ' . $result['city'] . ' ' . $result['province'] . ' ' . $result['region'] . ' ' . $result['zip'] ?>
                                </td>
                                <td>
                                    <?php
                                    $statuses = [
                                        1 => 'Under Investigation',
                                        2 => 'Surrendered',
                                        3 => 'Apprehended',
                                        4 => 'Escaped',
                                        5 => 'Deceased',
                                    ];
                                    echo $statuses[(int) $result['status']];
                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>
</body>

</html>