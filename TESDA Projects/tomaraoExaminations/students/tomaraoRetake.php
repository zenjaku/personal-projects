<?php
session_start();
include_once "../php/tomaraoConnection.php";
include('../php/retake.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tomaraoStyles.css">
    <title>Question <?= $page ?></title>
</head>
<body>
    <div class="main-container">
        <div class="container">
            <input type="hidden" name="studentID" id="studentID" value="<?= $studentId ?>">
            <p id="time" data-time="<?= $timeSeconds ?>"><?= $formattedTime ?></p>
            <form action="" method="POST" id="questionForm">
                <input type="hidden" name="qid" value="<?= $questionData['qid'] ?>">
                <h2 class="mt"><?= $page ?>. <?= $questionData['qns'] ?></h2>
                <div class="inputGroup">
                    <label><input type="radio" class="inputRadio" name="answer" value="a" required> A.
                        <?= $questionData['ch1'] ?></label>
                </div>
                <div class="inputGroup">
                    <label><input type="radio" class="inputRadio" name="answer" value="b"> B.
                        <?= $questionData['ch2'] ?></label>
                </div>
                <div class="inputGroup">
                    <label><input type="radio" class="inputRadio" name="answer" value="c"> C.
                        <?= $questionData['ch3'] ?></label>
                </div>
                <div class="inputGroup">
                    <label><input type="radio" class="inputRadio" name="answer" value="d"> D.
                        <?= $questionData['ch4'] ?></label>
                </div>
                <button type="submit" class="tomaraoSignup mt" name="retake">Submit Answer</button>
            </form>
        </div>
    </div>
</body>
<script>
    let time = parseInt(document.getElementById('time').getAttribute('data-time'));
    const form = document.getElementById('questionForm');

    function countdown() {
        if (time > 0) {
            let mins = Math.floor((time % 3600) / 60);
            let secs = time % 60;
            mins = mins < 10 ? '0' + mins : mins;
            secs = secs < 10 ? '0' + secs : secs;
            document.getElementById('time').innerText = `${mins}:${secs}`;
            time--;
        } else {
            document.getElementById('time').innerText = "00:00";
            alert('Time is up! Moving to the next question.');
            form.submit();
        }
    }

    setInterval(countdown, 1000);
</script>
</html>
