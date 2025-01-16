<?php
include_once "tomaraoConnection.php";
session_start();
$school_id = $_GET['school_id'];
$archiveQuery = "INSERT INTO archivedSchool (school_id, schoolName, schoolNumber, schoolLocation, logo)
                    SELECT school_id, schoolName, schoolNumber, schoolLocation, logo
                    FROM schoolInfo
                    WHERE school_id = '$school_id'";
$deleteQuery = "DELETE FROM schoolInfo WHERE school_id = '$school_id'";

if (mysqli_query($renzo, $archiveQuery) && mysqli_query($renzo, $deleteQuery)) {
    $_SESSION['status'] = 'success';
    $_SESSION['success'] = 'School deleted successfully.';
} else {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Failed to delete school.';
}

header("Location: ../views/tomaraoDashboard.php");
exit();
?>