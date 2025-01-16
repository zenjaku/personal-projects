<?php
session_start();
include("../php/tomaraoConnection.php");

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Please log in to continue.'); parent.location.href = '../tomaraoMainPage.php'; </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tomaraoStyles.css">
    <title>Add Exam</title>
</head>

<body>
    <div class="main-container">
        <div class="container">
            <h1>Enter Exam Details</h1>
            <form id="registerForm" action="../php/tomaraoAddExams.php" method="POST" autocomplete="off">
                <div class="inputGroup">
                    <input type="text" name="title" id="title" required placeholder="Enter exam title">
                </div>
                <div class="inputGroup">
                    <input type="number" name="total" id="total" required placeholder="Enter total number of questions">
                </div>
                <div class="inputGroup">
                    <input type="text" name="sahi" id="sahi" required placeholder="Enter marks on right answer">
                </div>
                <div class="inputGroup">
                    <input type="text" name="wrong" id="wrong" required
                        placeholder="Enter minus marks on wrong answer without sign">
                </div>
                <div class="inputGroup">
                    <input type="number" name="time" id="time" required
                        placeholder="Enter time limit for test in minutes" min="1"
                        oninput="this.value = Math.max(1, this.value)">
                </div>
                <div class="inputGroup">
                    <select name="tag" placeholder="Select difficulty" required>
                        <option value="" selected disabled>Enter #tag which is used for searching</option>
                        <option value="Easy">Easy</option>
                        <option value="Medium">Medium</option>
                        <option value="Hard">Hard</option>
                        <option hidden value="dummy">dummy</option>
                    </select>
                </div>
                <div class="inputGroup">
                    <textarea name="intro" id="intro" required placeholder="Write description here.."></textarea>
                </div>

                <input type="date" name="date" id="date" hidden>
                <button type="submit" class="tomaraoSignup" name="ADD">Submit</button>
                <button type="reset" class="tomaraoClear">Cancel</button>
            </form>
        </div>
    </div>

</body>

</html>