<?php
session_start();
include_once("../php/tomaraoConnection.php");
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Please log in to continue.'); parent.location.href = '../tomaraoMainPage.php'; </script>";
    exit;
}

$getEid = mysqli_query($renzo, "SELECT eid FROM quiz LIMIT 1");
$search = mysqli_fetch_assoc($getEid);
$eid = $search['eid'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tomaraoStyles.css">
    <title>Examination <?= $eid ?></title>
</head>

<body>
    <div class="studentContainer">
        
    <h1>List of Questions</h1>
        <table>
            <thead>
                <tr>
                    <th>
                        <h2>No.</h2>
                    </th>
                    <th>
                        <h2>Level</h2>
                    </th>
                    <th>
                        <h2>Questions</h2>
                    </th>
                    <th>
                        <h2>Choice 1</h2>
                    </th>
                    <th>
                        <h2>Choice 2</h2>
                    </th>
                    <th>
                        <h2>Choice 3</h2>
                    </th>
                    <th>
                        <h2>Choice 4</h2>
                    </th>
                    <th>
                        <h2>Answer</h2>
                    </th>
                    <th>
                        <h2>Actions</h2>
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php
                include('../php/tomaraoConnection.php');
                $query = "
                SELECT qu.qid, qu.qns, qu.ch1, qu.ch2, qu.ch3, qu.ch4, qu.sn, q.tag 
                FROM questions qu 
                JOIN quiz q ON qu.eid = q.eid
                    ";
                $getQuestions = mysqli_query($renzo, $query);

                $itemNumber = 1;
                while ($searchQns = mysqli_fetch_assoc($getQuestions)) {
                    ?>
                    <tr>
                        <td><?= $itemNumber++; ?></td>
                        <td><?= $searchQns['tag'] ?></td>
                        <td><?= $searchQns['qns'] ?></td>
                        <td><?= $searchQns['ch1'] ?></td>
                        <td><?= $searchQns['ch2'] ?></td>
                        <td><?= $searchQns['ch3'] ?></td>
                        <td><?= $searchQns['ch4'] ?></td>
                        <td><div class="tomaraoBtn uppercase"><?= $searchQns['sn'] ?></div></td>
                        <td class="btn-container">
                            <a href="pages/tomaraoEdit.php?qid=<?= $searchQns['qid'] ?>"><button type="button"
                                    class="tomaraoBtn" style="width: 10%;"> <img src="../assets/pencil.svg" alt="pencil" class="icons"> </button></a>
                            <a href="../php/tomaraoDelete.php?qid=<?= $searchQns['qid'] ?>"
                                onclick="return confirm ('Are you sure you want to delete the question?')">
                                <button type="submit" class="tomaraoView" style="width: 10%;"> <img src="../assets/trash3.svg" alt="trash" class="icons">  </button>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>