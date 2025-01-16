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
    <title>Available Tests</title>
</head>
<body>
    <div class="studentContainer">
        <h1>Available Exam</h1>
        <table>
            <thead>
                <tr>
                    <th><h2>Difficulty</h2></th>
                    <th><h2>Descriptions</h2></th>
                    <th><h2>Durations</h2></th>
                    <th><h2>No. of Questions</h2></th>
                    <th><h2>Status</h2></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $getExams = mysqli_query($renzo, "
                    SELECT qz.tag, qz.intro, qz.time, COUNT(q.qid) AS questionCount, qz.eid
                    FROM adminExam.quiz qz
                    JOIN adminExam.questions q ON q.eid = qz.eid
                    GROUP BY qz.eid
                    ORDER BY questionCount ASC
                ");

                $totalStudentsResult = mysqli_query($tomarao, "SELECT COUNT(*) AS studentCount FROM tomarao_Examination.registration WHERE `tomarao_type` != 1");
                $totalStudentsRow = mysqli_fetch_assoc($totalStudentsResult);
                $totalStudents = $totalStudentsRow['studentCount'];

                while ($exam = mysqli_fetch_assoc($getExams)) {
                    $quizTag = $exam['tag'];
                    $quizIntro = $exam['intro'];
                    $quizTime = $exam['time'];
                    $questionCount = $exam['questionCount'];
                    $quizId = $exam['eid'];

                    $completedStudentsResult = mysqli_query($renzo, "
                        SELECT COUNT(DISTINCT a.userId) AS completedCount
                        FROM adminExam.answer a
                        WHERE a.eid = '$quizId'
                    ");
                    $completedStudentsRow = mysqli_fetch_assoc($completedStudentsResult);
                    $completedStudents = $completedStudentsRow['completedCount'];
                    ?>
                    
                    <tr>
                        <td><?= $quizTag ?></td>
                        <td><?= $quizIntro ?></td>
                        <td><?= $quizTime ?> minute/s</td>
                        <td><?= $questionCount ?></td>
                        <td>
                            <?php
                            if ($completedStudents == $totalStudents) {
                                echo '<h2>Done</h2>';
                            } else {
                                echo '<h2 class="tomaraoBtn">Ongoing</h2>';
                            }
                            ?>
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
