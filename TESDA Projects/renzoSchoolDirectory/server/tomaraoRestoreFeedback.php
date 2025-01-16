<?php
include_once "tomaraoConnection.php";
session_start();

$feedback_id = $_GET['feedback_id'];

// Restore query
$restore = "INSERT INTO feedback (feedback_id, username, subject, message)
            SELECT feedback_id, username, subject, message
            FROM archivedFeedback
            WHERE feedback_id = '$feedback_id'";

// Delete from archive query
$deleteQuery = "DELETE FROM archivedFeedback WHERE feedback_id = '$feedback_id'";

if (mysqli_query($renzo, $restore) && mysqli_query($renzo, $deleteQuery)) {
    $_SESSION['status'] = 'success';
    $_SESSION['success'] = 'Feedback restored successfully.';
} else {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Failed to restore feedback.';
}

// Redirect to dashboard
header("Location: ../views/tomaraoDashboard.php");
exit();
?>