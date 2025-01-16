<?php
session_start();
include_once("../php/tomaraoConnection.php");
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
    <title>Available Tests</title>
</head>

<body>
    <div class="studentContainer">
        <h1>Student's Feedbacks</h1>
        <table>
            <th>
                <h2>Student Id</h2>
            </th>
            <th>
                <h2>Name</h2>
            </th>
            <th>
                <h2>Email Address</h2>
            </th>
            <th>
                <h2>Feedback</h2>
            </th>
            <th>
                <h2>Date</h2>
            </th>
            <th>
                <h2>Time</h2>
            </th>

            <tr>
                <?php
                $getFeedback = mysqli_query($renzo, "SELECT * FROM feedback");
                while ($searchQns = mysqli_fetch_assoc($getFeedback)) {
                    $feedId = $searchQns['feedId'];
                    $date = $searchQns['date'];
                    $timestamp = strtotime($date);
                    $formattedDate = gmdate("m-d-Y", $timestamp);
                    ?>
                <tr>
                    <td hidden><?= $feedId  ?></td>
                    <td><?= $searchQns['userId'] ?></td>
                    <td><?= $searchQns['name'] ?></td>
                    <td><?= $searchQns['email'] ?></td>
                    <td>
                        <button class="tomaraoSignup" onclick="openFeedback('<?= $feedId  ?>')">
                            <img src="../assets/folder.svg" alt="folder">
                        </button>
                        <div class="popupOverlay" id="popupOverlay_<?= $feedId ?>">
                            <div class="popup">
                                <?php
                                $getUser = mysqli_query($renzo, "SELECT subject, feedback FROM feedback WHERE feedId = '$feedId'");
                                if ($searchId = mysqli_fetch_assoc($getUser)) {
                                    ?>
                                    <div class="head">
                                        <h2><?= $searchId['subject'] ?></h2>
                                    </div>
                                    <div class="tbl">
                                        <p><?= $searchId['feedback'] ?></p>
                                    </div>
                                    <?php
                                }
                                ?>
                                <button class="tomaraoView mt" onclick="closeFeedback('<?= $feedId ?>')">Close</button>
                            </div>
                        </div>
                    </td>
                    <td><?= $formattedDate ?></td>
                    <td><?= $searchQns['time'] ?></td>
                </tr>
                <?php
                }
                ?>
            </tr>
        </table>
    </div>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function openFeedback(feedId) {
            const popup = document.getElementById('popupOverlay_' + feedId);

            if (popup) {
                popup.style.display = 'flex';
            }
        }

        function closeFeedback(feedId) {
            const popup = document.getElementById('popupOverlay_' + feedId);
            if (popup) {
                popup.style.display = 'none';
            }
        }
        window.openFeedback = openFeedback;
        window.closeFeedback = closeFeedback;
    });
</script>

</html>