<?php
session_start();
include_once "../php/tomaraoConnection.php";

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $studentId = $_SESSION['tomarao_Id'];
} else {
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
    <title>Available Tests</title>
</head>

<body>
    <input type="hidden" name="studentID" id="studentID" value="<?= $studentId ?>">
    <div class="studentContainer">
    <h1>Available Exam</h1>
        <table>
            <thead>
                <tr>
                    <th>
                        <h2>Difficulty</h2>
                    </th>
                    <th>
                        <h2>Descriptions</h2>
                    </th>
                    <th>
                        <h2>Durations</h2>
                    </th>
                    <th>
                        <h2>No. of Questions</h2>
                    </th>
                    <th>
                        <h2>Actions</h2>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getExam = mysqli_query($renzo, "SELECT a.ansIndex, q.sahi, q.wrong, a.correct, a.wrong AS qWrong, q.eid, q.tag, q.intro, q.time, q.total, a.ansid
                                  FROM quiz q
                                  LEFT JOIN answer a ON q.eid = a.eid AND a.userId = '$studentId' AND a.ansid = '1'
                                  ORDER BY FIELD(q.tag, 'Easy', 'Medium', 'Hard'), q.total ASC");

                $lastAnsweredDifficulty = '';

                while ($searchQns = mysqli_fetch_assoc($getExam)) {
                    $difficulty = $searchQns['tag'];
                    $isAnswered = !empty($searchQns['ansid']);

                    $answerIndex = $searchQns['ansIndex'];
                    $correct = $searchQns['correct'];
                    $hasPassed = $correct >= $searchQns['sahi'];
                    $hasFailed = $correct <= $searchQns['qWrong'];
                    $almostPassed = $correct >= $searchQns['sahi'] - 1;

                    $buttonEnabled = false;

                    if ($difficulty == 'Easy') {
                        $buttonEnabled = true;
                        if ($hasPassed) $lastAnsweredDifficulty = 'Easy';
                    } elseif ($difficulty == 'Medium' && $lastAnsweredDifficulty == 'Easy') {
                        $buttonEnabled = true;
                        if ($hasPassed) $lastAnsweredDifficulty = 'Medium';
                    } elseif ($difficulty == 'Hard' && $lastAnsweredDifficulty == 'Medium') {
                        $buttonEnabled = true;
                        if ($hasPassed) $lastAnsweredDifficulty = 'Hard';
                    }

                    ?>
                    <tr>
                        <td><?= $searchQns['tag'] ?></td>
                        <td><?= $searchQns['intro'] ?></td>
                        <td><?= $searchQns['time'] ?> minute/s</td>
                        <td><?= $searchQns['total'] ?></td>
                        <td>
                            <h2>
                                <?php
                                if ($isAnswered) {
                                    if ($hasPassed) {
                                        echo "$correct PASSED";
                                    } elseif ($hasFailed || $almostPassed) {
                                        echo "$correct FAILED";
                                        ?>
                                        <a href="tomaraoRetake.php?eid=<?= $searchQns['eid'] ?>">
                                            <button type="button" class="tomaraoBtn">Retake</button>
                                        </a>
                                        <?php
                                    } else {
                                        echo "Answered";
                                    }
                                } else {
                                    if (!$buttonEnabled) {
                                        ?>
                                        <button type="button" class="tomaraoView" disabled>Locked</button>
                                        <?php
                                    } else { ?>
                                        <a href="tomaraoQuestionnaire.php?eid=<?= $searchQns['eid'] ?>">
                                            <button type="button" class="tomaraoBtn">Answer</button>
                                        </a>
                                        <?php
                                    }
                                }
                                ?>
                            </h2>

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