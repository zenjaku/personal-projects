<?php
session_start();
include("../php/tomaraoConnection.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Please log in to continue.'); parent.location.href = '../tomaraoMainPage.php'; </script>";
    exit;
}

$studentId = $_SESSION['tomarao_Id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tomaraoStyles.css">
    <title>Add Exam</title>
</head>

<body>
    <div class="main-container">
        <div class="container">
            <input type="hidden" name="studentId" id="studentId" value="<?= $studentId ?>">
            <h1>Feedback</h1>
            <form id="registerForm" action="../php/tomaraoFeedback.php" method="POST" autocomplete="off">
                <?php
                $student = mysqli_query($tomarao, "SELECT * FROM registration WHERE tomarao_Id = '$studentId'");
                while ($search_users = mysqli_fetch_assoc($student)) {
                ?>
                <div class="inputGroup">
                    <input class="readOnly" type="text" name="name" id="name" value="<?= $search_users['tomarao_Fname'] . " " . $search_users['tomarao_Lname'] ?>" readonly>
                </div>
                <div class="inputGroup">
                <input class="readOnly" type="text" name="email" id="email" value="<?= $search_users['tomarao_Email']?>" readonly>
                </div>
                <div class="inputGroup">
                    <input type="text" name="subject" id="subject" required placeholder="Subject">
                </div>
                <div class="inputGroup">
                    <textarea name="feedback" id="feedback" required placeholder="Write your feedback here.."></textarea>
                </div>
                <?php
                }
                ?>
                <button type="submit" class="tomaraoLogin" name="send_feedback">Send</button>
                <button type="reset" class="tomaraoView">Cancel</button>
            </form>
        </div>
    </div>

</body>

</html>