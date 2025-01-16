<?php
include_once "../php/tomaraoConnection.php";
session_start();
include '../php/adminAdd.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tomaraoStyles.css">
    <title>Add Question <?= $page ?></title>
</head>
<body>
    <div class="main-container">
        <div class="container">
            <form action="tomaraoAddQuestions.php?page=<?= $page ?>&total=<?= $total ?>" method="POST">
                <input type="hidden" name="eid" value="<?= $eid ?>">
                <input type="hidden" name="page" value="<?= $page ?>">
                <div class="inputGroup">
                    <label for="question">Question <?= $page ?>:</label>
                    <input name="question" placeholder="" required>
                </div>
                <div class="inputGroup">
                    <label for="choice_a">Option A</label>
                    <input name="choice_a" required>
                </div>
                <div class="inputGroup">
                    <label for="choice_a">Option B</label>
                    <input name="choice_b"required>
                </div>
                <div class="inputGroup">
                    <label for="choice_a">Option C</label>
                    <input name="choice_c"required>
                </div>
                <div class="inputGroup">
                    <label for="choice_a">Option D</label>
                    <input name="choice_d"required>
                </div>
                <div class="inputGroup">
                    <label>Correct Answer:</label>
                    <select name="correct_answer" required>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                    </select>
                </div>
                <button type="submit" class="tomaraoSignup" name="submit_question">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
