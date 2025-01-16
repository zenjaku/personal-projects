<?php
session_start();
include_once "tomaraoConnection.php";
$feedback_id = $_GET['feedback_id'];

$archiveQuery = "INSERT INTO archivedFeedback (feedback_id, username, subject, message)
                    SELECT feedback_id, username, subject, message
                    FROM feedback
                    WHERE feedback_id = '$feedback_id'";
$deleteQuery = "DELETE FROM feedback WHERE feedback_id = '$feedback_id'";

if (mysqli_query($renzo, $archiveQuery) && mysqli_query($renzo, $deleteQuery)) {
    $_SESSION['status'] = 'success';
    $_SESSION['success'] = 'Feedback deleted successfully.';
} else {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Failed to delete feedback.';
}

header("Location: ../views/tomaraoDashboard.php");
exit();
?>