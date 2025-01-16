<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Welcome Page</title>
</head>

<body id="tomaraoMain">

    <?php
    include '../server/tomaraoConnection.php';
    session_start();

    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] === 'success' && isset($_SESSION['success'])) {
            ?>
            <div id="alertSuccess"><?= $_SESSION['success']; ?></div>

            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alertSuccess');
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 3000);
            </script>

            <?php
            unset($_SESSION['success']);
        } elseif (isset($_SESSION['failed'])) {
            ?>
            <div id="alertFailed"><?= $_SESSION['failed']; ?></div>

            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alertFailed');
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 3000);
            </script>

            <?php
            unset($_SESSION['failed']);
        }
        unset($_SESSION['status']);
    }

    // Fetch unique locations from the database
    $locationsQuery = "SELECT DISTINCT schoolLocation FROM schoolInfo";
    $locationsResult = mysqli_query($renzo, $locationsQuery);
    $locations = [];
    while ($row = mysqli_fetch_assoc($locationsResult)) {
        $locations[] = $row['schoolLocation'];
    }

    // Handle search and filter
    $searchQuery = isset($_GET['searchQuery']) ? mysqli_real_escape_string($renzo, $_GET['searchQuery']) : '';
    $location = isset($_GET['location']) && $_GET['location'] !== '--Select Location--' ?
        mysqli_real_escape_string($renzo, $_GET['location']) : '';

    $filterQuery = '';
    $conditions = [];
    if ($searchQuery) {
        $conditions[] = "schoolName LIKE '$searchQuery%'";
    }
    if ($location) {
        $conditions[] = "schoolLocation = '$location'";
    }

    if ($conditions) {
        $filterQuery = 'WHERE ' . implode(' AND ', $conditions);
    }

    // Pagination setup
    $limit = 5; // Number of records per page
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get the current page
    $offset = ($page - 1) * $limit; // Calculate the offset

    // Fetch paginated data
    $fetchSchoolQuery = "SELECT * FROM schoolInfo $filterQuery ORDER BY schoolName ASC LIMIT $limit OFFSET $offset";
    $schoolResult = mysqli_query($renzo, $fetchSchoolQuery);

    // Get total number of records to calculate total pages
    $countQuery = "SELECT COUNT(*) AS total FROM schoolInfo $filterQuery";
    $countResult = mysqli_query($renzo, $countQuery);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRecords / $limit); // Calculate total pages
    ?>

    <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
        <table class="main-table">
            <thead>
                <tr>
                    <th>
                        <div class="search-bar">
                            <form action="" method="get" id="searchForm">
                                <input type="text" name="searchQuery" class="input-fields"
                                    placeholder="Searching for school?" value="<?= htmlspecialchars($searchQuery) ?>">
                                <select name="location" id="location" style="cursor: pointer;">
                                    <option value="--Select Location--">--Select Location--</option>
                                    <?php foreach ($locations as $loc): ?>
                                        <option value="<?= htmlspecialchars($loc) ?>" <?= $loc === $location ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($loc) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" name="search" class="search-btn">Search</button>
                            </form>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($school = mysqli_fetch_assoc($schoolResult)): ?>
                    <tr>
                        <td>
                            <div class="school-name">
                                <?php
                                $logo = unserialize($school['logo']);
                                if (is_array($logo)) {
                                    foreach ($logo as $filePath) {
                                        echo '<img src="../server/' . htmlspecialchars($filePath) . '" alt="School Logo" style="max-width: 50px; max-height: 50px; margin-right: 5px;">';
                                    }
                                }
                                ?>
                                <div class="details">
                                    <h2><?= htmlspecialchars($school['schoolName']) ?></h2>
                                    <i><?= htmlspecialchars($school['schoolNumber']) ?></i>
                                    <em><?= htmlspecialchars($school['schoolLocation']) ?></em>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>&searchQuery=<?= urlencode($searchQuery) ?>&location=<?= urlencode($location) ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>

    <?php else: ?>
        <h1>Welcome to School Directory page</h1>
        <p>By: Renzo Tomarao</p>
    <?php endif; ?>

</body>

</html>
