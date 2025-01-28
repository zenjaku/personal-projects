<?php
include '../server/connections.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    // Query the database
    $sql = "SELECT * FROM assets WHERE sn LIKE '$name%'";
    $query = mysqli_query($conn, $sql);

    // Initialize an array to hold the data
    $data = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            'assets_id' => $row['assets_id'],
            'assets' => $row['assets'],
            'brand' => $row['brand'],
            'model' => $row['model'],
            'sn' => $row['sn'],
        ];
    }

    // If no results are found, handle accordingly
    if (empty($data)) {
        echo json_encode(['message' => 'No assets found']);
    } else {
        echo json_encode($data); // Return the data as JSON
    }
}




// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $name = mysqli_real_escape_string($conn, $_POST['name']); // Sanitize input

//     $sql = "SELECT * FROM assets WHERE assets LIKE '$name%'";
//     $query = mysqli_query($conn, $sql);

//     $data = '';
//     while ($row = mysqli_fetch_assoc($query)) {
//         // $data .= "<tr>
//         //             <td>" . htmlspecialchars($row['assets_id']) . "</td>
//         //             <td>" . htmlspecialchars($row['assets']) . "</td>
//         //             <td>" . htmlspecialchars($row['brand']) . "</td>
//         //             <td>" . htmlspecialchars($row['model']) . "</td>
//         //             <td>" . htmlspecialchars($row['sn']) . "</td>
//         //             <td>
//         //                 <a href='history.php?assets_id=" . htmlspecialchars($row['assets_id']) . "'>
//         //                     <button type='button' class='btn btn-dark' id='historyBtn'>View</button>
//         //                 </a>
//         //             </td>
//         //         </tr>
//         //           ";
//         $data = [
//             'assets_id'=> $row['assets_id'],
//             'assets'=> $row['assets'],
//             'brand'=> $row['brand'],
//             'model'=> $row['model'],
//             'sn'=> $row['sn'],
//         ];
//     }

//     echo $data ?: "<tr><td colspan='5'>No assets found</td>"; // Handle no results
// }

// $assetQuery = "SELECT DISTINCT assets FROM assets";
// $assetsResult = mysqli_query($conn, $assetQuery);
// $assets = [];
// while ($row = mysqli_fetch_assoc($assetsResult)) {
//     $assets[] = $row['assets'];
// }

// // Handle search and filter
// $searchAssets = isset($_GET['searchAssets']) ? mysqli_real_escape_string($conn, $_GET['searchAssets']) : '';
// $filterQuery = '';
// $conditions = [];
// if ($searchAssets) {
//     $conditions[] = "sn LIKE '%$searchAssets%'";
// }
// if ($conditions) {
//     $filterQuery = 'WHERE ' . implode(' AND ', $conditions);
// }

// $limit = 10;
// $pageInventory = isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
// $offset = ($pageInventory - 1) * $limit;

// $fetchAssets = "SELECT * FROM assets $filterQuery ORDER BY assets ASC LIMIT $limit OFFSET $offset";
// $showResult = mysqli_query($conn, $fetchAssets);

// $totalRowsQuery = str_replace("SELECT *", "SELECT COUNT(*) AS total", $fetchAssets);
// $totalRowsResult = mysqli_query($conn, $totalRowsQuery);
// if (!$totalRowsResult) {
//     die("Query Failed: " . mysqli_error($conn));
// }
// $totalRows = mysqli_fetch_assoc($totalRowsResult)['total'] ?? 0;
// $totalPages = $totalRows > 0 ? ceil($totalRows / $limit) : 1;
?>