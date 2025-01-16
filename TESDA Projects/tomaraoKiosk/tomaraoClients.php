<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/tomaraoStyles.css">
    <title>TOMARAO KIOSK</title>
</head>

<body id="clients">

    <h1>CLIENTS</h1>

    <div class="content">
        <table class="table">
            <tr>
                <td>FIRST NAME</td>
                <td>LAST NAME</td>
                <td>EMAIL</td>
                <td>TYPE</td>
                <td>STATUS</td>
            </tr>
            <?php
            include_once('php/tomaraoConnection.php');
            $search_users = mysqli_query($tomarao, "SELECT * FROM tomaraoregistration");
            while ($row = mysqli_fetch_assoc(($search_users))) {
                ?>
                <tr>
                    <td><?= $row['tomarao_Fname'] ?> </td>
                    <td><?= $row['tomarao_Lname'] ?> </td>
                    <td><?= $row['tomarao_Email'] ?> </td>
                    <td>
                        <h2><?= $row['tomarao_type'] === '0' ? 'Client' : 'Admin' ?></h2>
                    </td>
                    <td>
                        <?php
                        if ($row['tomarao_status'] === '0') { ?>
                            <a href="php/tomaraoClientsAction.php?id=<?= $row['id'] ?>" class="tomaraoBtn1"> Approve </a>
                        <?php } else { ?>

                            <h2>
                                <?= $row['tomarao_status'] === '0' ? 'Inactive' : 'Active' ?>
                            </h2>
                        <?php } ?>
                    </td>

                </tr>

                <?php
            }
            ?>
        </table>
    </div>


</body>

</html>