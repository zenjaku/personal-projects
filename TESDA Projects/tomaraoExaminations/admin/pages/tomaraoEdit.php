<?php
include("../../php/tomaraoConnection.php");

if (isset($_GET['qid'])) {
    $qid = $_GET['qid'];
    $getQuestions = mysqli_query($renzo, "SELECT * FROM questions WHERE qid = '$qid' LIMIT 1");

    if ($getQuestions && mysqli_num_rows($getQuestions) > 0) {
        $searchQns = mysqli_fetch_assoc($getQuestions);
    } else {
        echo "<script>alert('Question not found.');</script>";
        exit;
    }
} else {
    echo "<script>alert('No question ID provided.');</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_question'])) {
    $question = $_POST['question'];
    $choice_a = $_POST['choice_a'];
    $choice_b = $_POST['choice_b'];
    $choice_c = $_POST['choice_c'];
    $choice_d = $_POST['choice_d'];
    $correct_answer = $_POST['correct_answer'];

    $updateQuery = "UPDATE questions SET qns = '$question', ch1 = '$choice_a', ch2 = '$choice_b', ch3 = '$choice_c', ch4 = '$choice_d', sn = '$correct_answer' WHERE qid = '$qid'";

    if (mysqli_query($renzo, $updateQuery)) {
        echo "<script>alert('Question updated successfully.');
        window.location.href = '../tomaraoListOfQuestions.php'; </script>";
    } else {
        echo "<script>alert('Error updating question: " . mysqli_error($renzo) . "');
            window.location.href = 'tomaraoEdit.php'; </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/tomaraoStyles.css">
    <title>Edit Question <?= $qid; ?></title>
</head>

<body>
    <div class="main-container">
        <div class="container">
            <form action="" method="POST">
                <div class="inputGroup">
                    <input name="question" placeholder="<?= $searchQns['qns'] ?>" value="<?= $searchQns['qns'] ?>"
                        required>
                </div>
                <div class="inputGroup">
                    <label for="choice_a">A</label>
                    <input name="choice_a" placeholder="<?= $searchQns['ch1'] ?>" value="<?= $searchQns['ch1'] ?>"
                        required>
                </div>
                <div class="inputGroup">
                    <label for="choice_a">B</label>
                    <input name="choice_b" placeholder="<?= $searchQns['ch2'] ?>" value="<?= $searchQns['ch2'] ?>"
                        required>
                </div>
                <div class="inputGroup">
                    <label for="choice_a">C</label>
                    <input name="choice_c" placeholder="<?= $searchQns['ch3'] ?>" value="<?= $searchQns['ch3'] ?>"
                        required>
                </div>
                <div class="inputGroup">
                    <label for="choice_a">D</label>
                    <input name="choice_d" placeholder="<?= $searchQns['ch4'] ?>" value="<?= $searchQns['ch4'] ?>"
                        required>
                </div>
                <div class="inputGroup">
                    <label class="uppercase">Correct Answer: <?= $searchQns['sn'] ?></label>
                    <select name="correct_answer">
                        <option value="a" <?= $searchQns['sn'] == 'a' ? 'selected' : '' ?>>A</option>
                        <option value="b" <?= $searchQns['sn'] == 'b' ? 'selected' : '' ?>>B</option>
                        <option value="c" <?= $searchQns['sn'] == 'c' ? 'selected' : '' ?>>C</option>
                        <option value="d" <?= $searchQns['sn'] == 'd' ? 'selected' : '' ?>>D</option>
                    </select>
                </div>
                <button type="submit" class="tomaraoSignup" name="submit_question">Submit</button>
                <a href="../tomaraoListOfQuestions.php">
                    <button type="button" class="tomaraoView" name="submit_question">Cancel</button>
                </a>
            </form>
        </div>
    </div>
</body>

</html>