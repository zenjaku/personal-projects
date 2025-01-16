<?php
include '../auth/pages-security.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Profile</title>
</head>
<body id="profile">
    <?php
    include '../server/fetch-profile.php';
    ?>

    <div class="renzo-profile-container">
        <div class="renzo-profile-tab">
            <h2><?= $user['fname']; ?> <?= $user['lname']; ?></h2>
            <p><strong>Email Address: </strong><?= $user['email']; ?></p>
            <p><strong>Username: </strong><?= $user['username']; ?></p>
            <p><strong>Phone Number: </strong><?= $user['number']; ?></p>
            <p><strong>Address: </strong><?= $user['street']; ?> <?= $user['barangay']; ?> <?= $user['municipality']; ?> <?= $user['province']; ?> <?= $user['zipcode']; ?></p> 
        </div>
    </div>

    <!-- <a href="../server/edit-profile.php?username=<?= $user['username']; ?>">Fetch Profile</a> -->
</body>
</html>