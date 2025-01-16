<?php
include_once "tomaraoConnection.php";
session_start();

$school_id = $_GET['school_id'];

// Restore query
$restore = "INSERT INTO schoolInfo (school_id, schoolName, schoolNumber, schoolLocation, logo)
            SELECT school_id, schoolName, schoolNumber, schoolLocation, logo
            FROM archivedSchool
            WHERE school_id = '$school_id'";

// Delete from archive query
$deleteQuery = "DELETE FROM archivedSchool WHERE school_id = '$school_id'";

if (mysqli_query($renzo, $restore) && mysqli_query($renzo, $deleteQuery)) {
    $_SESSION['status'] = 'success';
    $_SESSION['success'] = 'School restored successfully.';
} else {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Failed to restore school.';
}

// Redirect to dashboard
header("Location: ../views/tomaraoDashboard.php");
exit();
?>