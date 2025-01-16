<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tomaraoStyles.css">
    <title>Tomarao Examinations</title>
</head>

<body class="tomaraoLoginSignUp">
    <ul class="navBtns">
        <?php
        if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
            //admin buttons
            if ($_SESSION['tomarao_Type'] === "1") {
                ?>
                <li><a href="../admin/tomaraoAvailableTests.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">Available Tests</button></a></li>
                <li><a href="../admin/tomaraoHistory.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">History</button></a></li>
                <li><a href="../admin/tomaraoStudents.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">Students</button></a></li>
                <li><a href="../admin/tomaraoRankings.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">Ranking</button></a></li>
                <li><a href="../admin/tomaraoFeedback.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">Feedback</button></a></li>
                <li><a href="../admin/tomaraoAddExams.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">Add Exams</button></a></li>
                <li><a href="../admin/tomaraoListOfQuestions.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">List of Questions</button></a></li>
                <?php
            } elseif ($_SESSION['tomarao_Type'] === "0") {
                ?>
                <?php
                ?>
                <li><a href="../students/tomaraoAvailableTests.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">Available Tests</button></a></li>
                <li><a href="../students/tomaraoHistory.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">History</button></a></li>
                <li><a href="../students/tomaraoRankings.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">Ranking</button></a></li>
                <li><a href="../students/tomaraoFeedback.php" target="mid_column"><button type="button" class="tomaraoView"
                            style="width: 100%; font-size: 13px;">Add feedback</button></a></li>

                <?php
            }
            ?>
            <li><a href="../php/tomaraoLogout.php"><button type="button" class="tomaraoClear"
                        style="width: 100%; font-size: 13px;">Logout</button></a></li>
            <?php
        } else {
            ?>
            <li><a href="../tomaraoLogin.php" target="mid_column"><button type="button" class="tomaraoLogin"
                        style="width: 100%; font-size: 13px;">Login</button></a></li>
            <li><a href="../tomaraoRegistration.php" target="mid_column"><button type="button" class="tomaraoSignup"
                        style="width: 100%; font-size: 13px;">Register</button></a></li>
            <?php
        }
        ?>
    </ul>

</body>

</html>