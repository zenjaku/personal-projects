<?php
session_start();
include_once("../php/tomaraoConnection.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Please log in to continue.'); parent.location.href = '../tomaraoMainPage.php'; </script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tomaraoStyles.css">
    <title>List of Students</title>
</head>

<body>
    <div class="studentContainer">
        
    <h1>List of Students</h1>
        <table>
            <th>
                <h2>Student Id</h2>
            </th>
            <th>
                <h2>Name</h2>
            </th>
            <th>
                <h2>Email Address</h2>
            </th>
            <th>
                <h2>Actions</h2>
            </th>

            <tr>
                <?php
                include('../php/tomaraoConnection.php');
                $getStudents = mysqli_query($tomarao, 'SELECT * FROM registration WHERE `tomarao_type` != 1');

                while ($search = mysqli_fetch_assoc($getStudents)) {
                    $studentId = substr($search['tomarao_Id'], 0, 15);
                    ?>
                <tr>
                    <td><?= $studentId ?></td>
                    <td><strong><?= $search['tomarao_Fname'] . " " . $search['tomarao_Lname']; ?></strong></td>
                    <td><?= $search['tomarao_Email'] ?></td>

                    <td>
                        <?php
                        if ($search['tomarao_Status'] === '0') { ?>
                            <a href="../php/tomaraoStudent.php?tomarao_Id=<?= $search['tomarao_Id'] ?>">
                                <button type="submit" class="tomaraoBtn">Approve</button></a>
                        <?php } else { ?>
                            <h2>
                                <?= $search['tomarao_Status'] === '1' ? 'Active' : 'Inactive' ?>
                            </h2>
                        <?php } ?>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tr>
        </table>
    </div>

</body>

</html>