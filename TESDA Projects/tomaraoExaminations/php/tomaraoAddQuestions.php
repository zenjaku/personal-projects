<?php
include_once "tomaraoConnection.php";

if (isset($_POST['submit_question'])) {
    $eid = $_POST['eid'];
    $page = (int)$_POST['page'];
    $total = (int)$_GET['total'];

    $question = $_POST['question'];
    $choiceA = $_POST['choice_a'];
    $choiceB = $_POST['choice_b'];
    $choiceC = $_POST['choice_c'];
    $choiceD = $_POST['choice_d'];
    $correctAnswer = $_POST['correct_answer'];

    $qid = generateUniqueQid($renzo);

    $query = "INSERT INTO questions (eid, qid, qns, ch1, ch2, ch3, ch4, sn)
              VALUES ('$eid', '$qid', '$question', '$choiceA', '$choiceB', '$choiceC', '$choiceD', '$correctAnswer')";

    if (!mysqli_query($renzo, $query)) {
        echo "<script>alert('Error saving question $page.');</script>";
        exit;
    }

    if ($page < $total) {
        $nextPage = $page + 1;
        header("Location: tomaraoAddQuestions.php?page=$nextPage&total=$total");
    } else {
        echo "<script>alert('All questions saved successfully!'); window.location.href='tomaraoAvailableTests.php';</script>";
    }
    exit;
}

mysqli_close($renzo);