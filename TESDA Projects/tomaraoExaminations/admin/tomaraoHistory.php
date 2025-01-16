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
    <h1>History</h1>
        <table>
            <th>
                <h2>No.</h2>
            </th>
            <th>
                <h2>Student Id</h2>
            </th>
            <th>
                <h2>Email</h2>
            </th>
            <th>
                <h2>Name</h2>
            </th>
            <th>
                <h2>Exam Id</h2>
            </th>
            <th>
                <h2>Score</h2>
            </th>
            <th>
                <h2>Level</h2>
            </th>
            <th>
                <h2>Date</h2>
            </th>

            <tr><?php
            include('../php/tomaraoConnection.php');

            $query = "
                        SELECT 
                            a.userId,
                            a.eid,
                            a.correct,
                            a.wrong,
                            a.date,
                            q.tag,
                            q.sahi,
                            q.wrong AS qWrong,
                            r.tomarao_Email,
                            r.tomarao_Fname,
                            r.tomarao_Lname
                        FROM 
                            adminExam.answer a
                        JOIN 
                            tomarao_Examination.registration r ON a.userId = r.tomarao_Id
                        JOIN 
                            adminExam.quiz q ON a.eid = q.eid
                        WHERE 
                            r.tomarao_type != 1
                    ";

            $getResults = mysqli_query($renzo, $query);
            $itemNumber = 1;

            while ($row = mysqli_fetch_assoc($getResults)) {
                $eid = substr($row['eid'], 0, 15);
                $studentId = substr($row['userId'], 0, 15);
                ?>
                <tr>
                    <td><?= $itemNumber++ ?></td>
                    <td><?= $studentId ?></td>
                    <td><?= $row['tomarao_Email'] ?></td>
                    <td><strong><?= $row['tomarao_Fname'] . " &nbsp; " . $row['tomarao_Lname'] ?></strong></td>
                    <td><?= $eid ?></td>
                    <td>
                        <?php
                        $correct = $row['correct'];
                        $wrong = $correct - $row['wrong'];

                        if ($correct >= $row['sahi']) {
                            echo "<strong>$correct <br/></strong> (PASSED)";
                        } elseif ($wrong <= $row['qWrong']) {
                            echo "<strong>$wrong <br/></strong> (FAILED)";
                        } elseif ($correct >= $row['sahi'] - 1) {
                            echo "<strong>$correct <br/></strong> (ALMOST PASSED)";
                        } else {
                            echo "<strong>Score not available based on conditions.</strong>";
                        }
                        ?>

                    </td>
                    <td><?= $row['tag'] ?></td>
                    <td><?= $row['date'] ?></td>
                </tr>
                <?php
            }
            ?>

            </tr>
        </table>
    </div>

</body>

</html>