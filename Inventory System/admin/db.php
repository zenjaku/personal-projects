<?php
include 'admin/auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Import/Export</title>
</head>

<body>
    <div class="container py-3">
        <h1>DATABASE BACKUP</h1>
        <div class="row my-5">
            <div class="col-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h3>Export Database</h3>
                    </div>
                    <div class="card-body text-center py-5">
                        <form action="admin/database.php" method="GET">
                            <?php
                            $result = $conn->query("SELECT DATABASE()");
                            $row = $result->fetch_row();
                            $currentDbName = $row[0];
                            ?>

                            <p><?='Export '. $currentDbName . ' ?'?></p>
                            <button type="submit" class="btn btn-dark" name="export">Export Database</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h2>Import Database</h2>
                    </div>
                    <div class="card-body">
                        <form action="admin/database.php" class="my-3 d-flex flex-column gap-4" method="POST"
                            enctype="multipart/form-data">
                            <div class="form-floating">
                                <input type="file" class="form-control" name="sql_file" id="sql_file" accept=".sql"
                                    required>
                                <label for="sql_file">Upload SQL file</label>
                            </div>
                            <button type="submit" class="btn btn-dark" name="import">Import Database</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
<?php

?>