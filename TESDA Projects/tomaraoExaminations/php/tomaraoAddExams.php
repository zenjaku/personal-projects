<?php
include_once "tomaraoConnection.php";

function generateUniqueEid($connection)
{
    do {
        
        $eid = bin2hex(random_bytes(20));

        $result = mysqli_query($connection, "SELECT 1 FROM quiz WHERE eid = '$eid'");

    } while (mysqli_num_rows($result) > 0);

    return $eid;
}

if (isset($_POST["ADD"])) {
    $title = $_POST["title"];
    $total = $_POST["total"];
    $sahi = $_POST["sahi"];
    $wrong = $_POST["wrong"];
    $time = $_POST["time"];
    $tag = $_POST["tag"];
    $intro = $_POST["intro"];
    $date = date('Y-m-d H:i:s');

    $checkTitle = mysqli_query($renzo, "SELECT * FROM quiz WHERE title = '$title'");

    if (mysqli_num_rows($checkTitle) == 1) {
        echo "<script> alert ('The title is not available.');
                window.location.href = '../admin/tomaraoAddExams.php'; </script>";
        return;
    }

    
    $checkTag = mysqli_query($renzo, "SELECT * FROM quiz WHERE tag = '$tag'");

    if (mysqli_num_rows($checkTag) == 1) {
        echo "<script> alert ('$tag difficulty is already available in the test.');
                window.location.href = '../admin/tomaraoAddExams.php'; </script>";
        return;
    }

    $eid = generateUniqueEid($renzo);

    $questions = mysqli_query($renzo, "INSERT INTO quiz (eid, title, total, sahi, wrong, time, tag, intro, date)
                    VALUES ('$eid', '$title', '$total', '$sahi', '$wrong', '$time', '$tag', '$intro', '$date')");

    if (!$questions) {
        echo "<script> alert ('Oops! Something went wrong, please try again later!'); 
            window.location.href = '../admin/tomaraoAddExams.php'; </script>";
        return;
    }

    echo "<script> alert ('Exam created successfully'); 
    window.location.href ='../admin/tomaraoAddQuestions.php?total=$total'; </script>";
}

mysqli_close($renzo);