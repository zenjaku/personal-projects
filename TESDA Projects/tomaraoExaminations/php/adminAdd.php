<?php
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Please log in to continue.'); parent.location.href = '../tomaraoMainPage.php'; </script>";
    exit;
}

$total = isset($_GET['total']) ? (int)$_GET['total'] : 1;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

function generateUniqueQid($renzo) {
    do {
        $qid = bin2hex(random_bytes(8));
        $result = mysqli_query($renzo, "SELECT 1 FROM questions WHERE qid = '$qid'");
    } while (mysqli_num_rows($result) > 0);
    return $qid;
}

$eidQuery = mysqli_query($renzo, "SELECT eid FROM quiz LIMIT 1");
if ($eidQuery && mysqli_num_rows($eidQuery) > 0) {
    $examData = mysqli_fetch_assoc($eidQuery);
    $eid = $examData['eid'];
} else {
    echo "<script>alert('No exams found in the database. Please add an exam first.');</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_question'])) {
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

    $nextPage = $page + 1;
    if ($nextPage <= $total) {
        header("Location: tomaraoAddQuestions.php?page=$nextPage&total=$total");
    } else {
        echo "<script>alert('All questions saved successfully!'); window.location.href='tomaraoListOfQuestions.php';</script>";
    }
    exit;
}
mysqli_close($renzo);