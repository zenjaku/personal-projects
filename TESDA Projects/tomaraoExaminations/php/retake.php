<?php
if (isset($_SESSION['displayed_qids'])) {
    echo "<pre>Displayed QIDs: ";
    print_r($_SESSION['displayed_qids']);
    echo "</pre>";
} else {
    echo "<pre>No displayed questions stored in session.</pre>";
}

$timeoutDuration = 1800;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeoutDuration) {
    unset($_SESSION['displayed_qids'], $_SESSION['correct'], $_SESSION['wrong']);
    session_unset();
    session_destroy();
    session_start();
    $_SESSION['message'] = "Session expired. Please start the quiz again.";
}

$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Please log in to continue.'); parent.location.href = '../tomaraoMainPage.php'; </script>";
    exit;
}

$studentId = $_SESSION['tomarao_Id'];
$_SESSION['correct'] = $_SESSION['correct'] ?? 0;
$_SESSION['wrong'] = $_SESSION['wrong'] ?? 0;
$_SESSION['displayed_qids'] = $_SESSION['displayed_qids'] ?? [];

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$eid = $_GET['eid'] ?? null;

function noDuplicate($blockQid, $eid)
{
    if (!isset($_SESSION['displayed_qids'])) {
        $_SESSION['displayed_qids'] = [];
    }

    $qid = null;

    do {
        $result = mysqli_query($blockQid, "SELECT qid FROM questions WHERE eid = '$eid' ORDER BY RAND() LIMIT 1");
        $row = mysqli_fetch_assoc($result);
        $qid = $row['qid'];
    } while (in_array($qid, $_SESSION['displayed_qids']) && $qid !== null);

    $_SESSION['displayed_qids'][] = $qid;
    return $qid;
}

if ($eid) {
    if (!isset($_SESSION['current_qid']) || $_SESSION['current_page'] !== $page) {
        $qid = noDuplicate($renzo, $eid);
        $_SESSION['current_qid'] = $qid;
        $_SESSION['current_page'] = $page;
    } else {
        $qid = $_SESSION['current_qid'];
    }

    $questionsQuery = mysqli_query($renzo, "SELECT * FROM questions WHERE qid = '$qid' LIMIT 1");
    $questionData = mysqli_fetch_assoc($questionsQuery) ?: null;

    if (!$questionData) {
        echo "<script>alert('No questions found for this exam.'); window.location.href='tomaraoAvailableTests.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid exam selection.'); window.location.href='tomaraoAvailableTests.php';</script>";
    exit;
}


$setTimer = mysqli_query($renzo, "SELECT * FROM quiz WHERE eid = '$eid'");
$search = mysqli_fetch_assoc($setTimer);
$timeMinute = $search['time'];
$timeSeconds = $timeMinute * 60;
$formattedTime = gmdate("i:s", $timeSeconds);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qid'])) {
    $qid = $_POST['qid'];
    $studentAnswer = $_POST['answer'] ?? 'incorrect';

    $query = mysqli_query($renzo, "SELECT sn FROM questions WHERE qid = '$qid'");
    $correctAnswer = mysqli_fetch_assoc($query)['sn'];

    if ($studentAnswer === $correctAnswer) {
        $_SESSION['correct']++;
    } else {
        $_SESSION['wrong']++;
    }

    $totalQuestionsQuery = mysqli_query($renzo, "SELECT COUNT(*) as total FROM questions WHERE eid = '$eid'");
    $totalQuestions = mysqli_fetch_assoc($totalQuestionsQuery)['total'];

    if ($page >= $totalQuestions) {
        $correct = $_SESSION['correct'];
        $wrong = $_SESSION['wrong'];
        $date = date('Y-m-d H:i:s');

        mysqli_query($renzo, "UPDATE answer SET correct = '$correct', wrong = '$wrong', date = '$date' WHERE userId = '$studentId' AND eid = '$eid'");

        unset($_SESSION['displayed_qids'], $_SESSION['correct'], $_SESSION['wrong']);

        echo "<script>alert('Retake completed! Results have been submitted.'); window.location.href = 'tomaraoAvailableTests.php';</script>";
        exit;
    } else {
        $nextPage = $page + 1;
        header("Location: tomaraoRetake.php?page=$nextPage&eid=$eid");
        exit;
    }
}

?>