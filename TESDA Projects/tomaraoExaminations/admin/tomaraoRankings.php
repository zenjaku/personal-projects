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
        <h1>Rankings</h1>
        <form id="filterForm" method="GET">
            <div class="filter">
                <h2><input type="checkbox" name="easy" value="1" onchange="this.form.submit()" <?php if (isset($_GET['easy']) && $_GET['easy'] == '1')
                    echo 'checked'; ?>> Easy</h2>
                <h2><input type="checkbox" name="medium" value="1" onchange="this.form.submit()" <?php if (isset($_GET['medium']) && $_GET['medium'] == '1')
                    echo 'checked'; ?>> Medium</h2>
                <h2><input type="checkbox" name="hard" value="1" onchange="this.form.submit()" <?php if (isset($_GET['hard']) && $_GET['hard'] == '1')
                    echo 'checked'; ?>> Hard</h2>
                <?php
                $currentDate = date("(M d Y | D)");
                ?>
                <div class="date">
                    <h2>As of <?= $currentDate ?></h2>
                </div>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>
                        <h2>Rank</h2>
                    </th>
                    <th>
                        <h2>Name</h2>
                    </th>
                    <th>
                        <h2>Score</h2>
                    </th>
                    <th>
                        <h2>Level</h2>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../php/tomaraoConnection.php');

                $filter = [];
                if (isset($_GET['easy']) && $_GET['easy'] == '1') {
                    $filter[] = "'Easy'";
                }
                if (isset($_GET['medium']) && $_GET['medium'] == '1') {
                    $filter[] = "'Medium'";
                }
                if (isset($_GET['hard']) && $_GET['hard'] == '1') {
                    $filter[] = "'Hard'";
                }
                $filterQuery = '';
                if (!empty($filter)) {
                    $filterQuery = "AND q.tag IN (" . implode(",", $filter) . ")";
                }

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
                        $filterQuery
                    ORDER BY 
                        a.correct DESC
                ";

                $getResults = mysqli_query($renzo, $query);
                $itemNumber = 1;

                while ($row = mysqli_fetch_assoc($getResults)) {
                    $eid = substr($row['eid'], 0, 15);
                    $studentId = substr($row['userId'], 0, 15);
                    ?>
                    <tr>
                        <td><?= $itemNumber++ ?></td>
                        <td hidden><?= $studentId ?></td>
                        <td><strong><?= $row['tomarao_Fname'] . " " . $row['tomarao_Lname'] ?></strong></td>
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
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>