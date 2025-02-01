<?php
// Fetch Computer Specifications
if (isset($_GET['cname']) && !empty($_GET['cname'])) {
    $cname_id = $_GET['cname'];

    // Prepare a single query to fetch all relevant data
    $fetchSpecs = $conn->prepare("
        SELECT c.cname, a.assets_id, a.assets, a.sn, a.brand, a.model 
        FROM computer c 
        LEFT JOIN assets a ON a.assets_id = c.assets_id 
        WHERE c.cname = ?
    ");
    $fetchSpecs->bind_param("s", $cname_id);
    $fetchSpecs->execute();
    $result = $fetchSpecs->get_result();

    // Fetch all rows into an array
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Get the computer name from the first row
    $cname = $rows[0]['cname'];
}
?>
<div class="container py-2">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>SPECIFICATIONS FOR <?= htmlspecialchars($cname) ?></h3>
            <a href="/inventory">
                <button class="btn btn-danger" id="closeModal">X</button>
            </a>
        </div>
        <div class="card-body">
            <table class="table text-uppercase table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Assets ID</th>
                        <th scope="col">SPECIFIED</th>
                        <th scope="col">BRAND</th>
                        <th scope="col">MODEL</th>
                        <th scope="col">S/N</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through all the rows
                    foreach ($rows as $specs) {
                        ?>
                        <tr>
                            <td>
                                <p class="my-2"><?= htmlspecialchars($specs['assets_id']) ?></p>
                            </td>
                            <td>
                                <p class="my-2"><?= htmlspecialchars($specs['assets']) ?></p>
                            </td>
                            <td>
                                <p class="my-2"><?= htmlspecialchars($specs['brand']) ?></p>
                            </td>
                            <td>
                                <p class="my-2"><?= htmlspecialchars($specs['model']) ?></p>
                            </td>
                            <td>
                                <p class="my-2"><?= htmlspecialchars($specs['sn']) ?></p>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>