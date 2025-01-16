<?php
include_once '../server/tomaraoConnection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/script.js"></script>
    <title>Admin Dashboard</title>
</head>

<body>

    <?php
    session_start();
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] === 'success' && isset($_SESSION['success'])) {
            ?>
            <div id="alertSuccess"><?= $_SESSION['success']; ?></div>

            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alertSuccess');
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 3000);
            </script>

            <?php
            unset($_SESSION['success']);
        } elseif (isset($_SESSION['failed'])) {
            ?>
            <div id="alertFailed"><?= $_SESSION['failed']; ?></div>

            <script>
                setTimeout(function () {
                    const alertElement = document.getElementById('alertFailed');
                    if (alertElement) {
                        alertElement.remove();
                    }
                }, 3000);
            </script>

            <?php
            unset($_SESSION['failed']);
        }
        unset($_SESSION['status']);
    }

    if (isset($_SESSION['type']) && (int) $_SESSION['type'] === 1) {
        ?>
        <div class="dashboard-btns">
            <button type="button" class="admin-btns" id="profile">Profile</button>
            <button type="button" class="admin-btns" id="users">Users</button>
            <button type="button" class="admin-btns" id="schoolInfo">School Information</button>
            <button type="button" class="admin-btns" id="feedback">Feedback</button>
            <button type="button" class="admin-btns" id="archived">Archived</button>
        </div>

        <div id="profileModal">
            <div class="card">
                <div class="profile-picture">
                    <?php
                    $username = $_SESSION['username'];
                    $fetchPhoto = "SELECT * FROM photos WHERE username = '$username'";
                    $searchPhoto = mysqli_query($renzo, $fetchPhoto);

                    if ($searchPhoto && mysqli_num_rows($searchPhoto) > 0) {
                        $results = mysqli_fetch_assoc($searchPhoto);
                        $photo = isset($results['profile_photo']) ? unserialize($results['profile_photo']) : false;
                        ?>
                        <div class="profile-photo">
                            <?php
                            if (is_array($photo)) {
                                foreach ($photo as $filePath) {
                                    echo '<img src="../server/' . $filePath . '" alt="Profile Photo" style="max-width: 100px; max-height: 100px; margin-right: 5px;">';
                                }
                            }

                            ?>
                            <a href="../server/changePhoto.php?username=<?= $username ?>">
                                <button class="renzo-primary-btn">Change</button>
                            </a>
                        </div>
                        <?php
                    } else {
                        ?>
                        <form action="../server/tomaraoMethod.php" method="post" enctype="multipart/form-data"
                            id="profilePhotoForm">
                            <div class="form-floating">
                                <input type="file" name="profile-photo" id="profilePhoto" accept=".jpeg, .jpg, .png">
                                <label for="profilePhoto">Profile Photo</label>
                            </div>
                            <button name="profile-photo" class="renzo-primary-btn" type="submit">Save</button>
                        </form>
                        <?php
                    }
                    ?>

                </div>
                <div class="card-header">
                    <?php
                    $username = $_SESSION['username'];
                    $fetchUsers = "SELECT * FROM users WHERE username = '$username'";
                    $searchUsers = mysqli_query($renzo, $fetchUsers);
                    $results = mysqli_fetch_assoc($searchUsers);
                    ?>
                    <p><?= $results['fname'] . ' ' . $results['lname'] ?></p>
                    <p>@<?= $_SESSION['username'] ?></p>
                </div>
                <hr>
                <div class="card-body">
                    <p><strong>Email Address:</strong> <?= $results['email'] ?></p>
                </div>
            </div>
        </div>

        <div id="usersModal">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>User Id</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fetchUsers = "SELECT * FROM users";
                    $searchUsers = mysqli_query($renzo, $fetchUsers);
                    while ($results = mysqli_fetch_assoc($searchUsers)) {
                        ?>
                        <tr>
                            <td><?= $results['id'] ?></td>
                            <td><?= $results['username'] ?></td>
                            <td><?= $results['fname'] . ' ' . $results['lname'] ?></td>
                            <td><?= $results['email'] ?></td>
                            <td>
                                <?php
                                if ((int) $results['type'] === 1) {
                                    ?>
                                    Admin
                                    <?php
                                } elseif ((int) $results['type'] === 0) {
                                    ?>
                                    <div class="user">
                                        <p>Users</p>
                                        <form action="" method="post">
                                            <input type="hidden" value="<?= $results['username'] ?>" name="username">
                                            <button type="submit" class="logout-btn" name="deactivate">Deactivate</button>
                                        </form>
                                    </div>
                                    <?php
                                } elseif ((int) $results['type'] === 2) {
                                    ?>
                                    <div class="user">
                                        <p>Deactivated</p>
                                        <form action="" method="post">
                                            <input type="hidden" value="<?= $results['username'] ?>" name="username">
                                            <button type="submit" class="renzo-primary-btn" name="reactivate">Re-activate</button>
                                        </form>
                                    </div>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="schoolModal">
            <div>
                <button type="button" class="renzo-primary-btn" popovertarget="addSchool"> Add School</button>
            </div>
            <table class="main-table">
                <thead>
                    <tr>
                        <th>School Id</th>
                        <th>Logo</th>
                        <th>School Name</th>
                        <th>Contact Details</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fetchSchool = "SELECT * FROM schoolInfo";
                    $search = mysqli_query($renzo, $fetchSchool);
                    while ($results = mysqli_fetch_assoc($search)) {
                        $logo = unserialize($results['logo']);
                        ?>
                        <tr>
                            <td><?= $results['school_id'] ?></td>
                            <td>
                                <?php
                                if (is_array($logo)) {
                                    foreach ($logo as $filePath) {
                                        echo '<img src="../server/' . $filePath . '" alt="School Logo" style="max-width: 100px; max-height: 100px; margin-right: 5px;">';
                                    }
                                }
                                ?>
                            </td>
                            <td><?= $results['schoolName'] ?></td>
                            <td><?= $results['schoolNumber'] ?></td>
                            <td><?= $results['schoolLocation'] ?></td>
                            <td>
                                <a href="../server/tomaraoEditSchool.php?school_id=<?= $results['school_id']; ?>">
                                    <button type="button" class="action-btns">Edit</button></a>
                                <a href="../server/tomaraoDelete.php?school_id=<?= $results['school_id']; ?>">
                                    <button type="button" class="action-btns"
                                        onclick="return confirm('Are you sure you want to delete <?= $results['schoolName']; ?>?')">Delete</button></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>

        <div id="feedbacks">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Feedback</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fetchFeedbacks = "SELECT * FROM feedback";
                    $searchFeedback = mysqli_query($renzo, $fetchFeedbacks);
                    while ($results = mysqli_fetch_assoc($searchFeedback)) {
                        ?>
                        <tr>
                            <td><?= $results['username'] ?></td>
                            <td><strong><?= $results['subject'] ?></strong> | <?= $results['message'] ?></td>
                            <td><?= $results['created_at'] ?></td>
                            <td>
                                <a href="../server/deleteFeedback.php?feedback_id=<?= $results['feedback_id'] ?>">
                                    <button type="button" class="action-btns"
                                        onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</button>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="archivedModal">
            <h1 style="margin-bottom: 1em; text-align: center;">Archived Files</h1>
            <button type="buttons" class="archived-btns" id="schoolData">School Information</button>
            <button type="buttons" class="archived-btns" id="feedbackData">Feedbacks</button>
        </div>

        <div id="feedbackArchived">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Feedback</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fetchFeedbacks = "SELECT * FROM archivedFeedback";
                    $searchFeedback = mysqli_query($renzo, $fetchFeedbacks);
                    while ($results = mysqli_fetch_assoc($searchFeedback)) {
                        ?>
                        <tr>
                            <td><?= $results['username'] ?></td>
                            <td><strong><?= $results['subject'] ?></strong> | <?= $results['message'] ?></td>
                            <td><?= $results['created_at'] ?></td>
                            <td>
                                <a href="../server/tomaraoRestoreFeedback.php?feedback_id=<?= $results['feedback_id'] ?>">
                                    <button type="button" class="action-btns"
                                        onclick="return confirm('Are you sure you want to restore this feedback?')">Restore</button>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="schoolArchived">
            <table class="main-table">
                <thead>
                    <tr>
                        <th>School Id</th>
                        <th>Logo</th>
                        <th>School Name</th>
                        <th>Contact Details</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $fetchArchivedSchool = "SELECT * FROM archivedSchool";
                    $search = mysqli_query($renzo, $fetchArchivedSchool);
                    while ($results = mysqli_fetch_assoc($search)) {
                        $logo = unserialize($results['logo']);
                        ?>
                        <tr>
                            <td><?= $results['school_id'] ?></td>
                            <td>
                                <?php
                                if (is_array($logo)) {
                                    foreach ($logo as $filePath) {
                                        echo '<img src="../server/' . $filePath . '" alt="School Logo" style="max-width: 100px; max-height: 100px; margin-right: 5px;">';
                                    }
                                }
                                ?>
                            </td>
                            <td><?= $results['schoolName'] ?></td>
                            <td><?= $results['schoolNumber'] ?></td>
                            <td><?= $results['schoolLocation'] ?></td>
                            <td>
                                <a href="../server/tomaraoRestoreSchool.php?school_id=<?= $results['school_id']; ?>">
                                    <button type="button" class="action-btns"
                                        onclick="return confirm('Are you sure you want to restore <?= $results['schoolName']; ?>?')">Restore</button></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>

        <?php
    } else {
        ?>
        <div class="user-buttons">
            <button id="profileBtn" class="admin-btns">Profile</button>
            <button id="addFeedback" class="admin-btns">Feedback</button>
        </div>
        <div id="userModal">
            <div class="card">
                <div class="profile-picture">
                    <?php
                    $username = $_SESSION['username'];
                    $fetchPhoto = "SELECT * FROM photos WHERE username = '$username'";
                    $searchPhoto = mysqli_query($renzo, $fetchPhoto);

                    if ($searchPhoto && mysqli_num_rows($searchPhoto) > 0) {
                        $results = mysqli_fetch_assoc($searchPhoto);
                        $photo = isset($results['profile_photo']) ? unserialize($results['profile_photo']) : false;
                        ?>
                        <div class="profile-photo">
                            <?php
                            if (is_array($photo)) {
                                foreach ($photo as $filePath) {
                                    echo '<img src="../server/' . $filePath . '" alt="Profile Photo" style="max-width: 100px; max-height: 100px; margin-right: 5px;">';
                                }
                            }

                            ?>
                            <a href="../server/changePhoto.php?username=<?= $username ?>">
                                <button class="renzo-primary-btn">Change</button>
                            </a>
                        </div>
                        <?php
                    } else {
                        ?>
                        <form action="../server/tomaraoMethod.php" method="post" enctype="multipart/form-data"
                            id="profilePhotoForm">
                            <div class="form-floating">
                                <input type="file" name="profile-photo" id="profilePhoto" accept=".jpeg, .jpg, .png">
                                <label for="profilePhoto">Profile Photo</label>
                            </div>
                            <button name="profile-photo" class="renzo-primary-btn" type="submit">Save</button>
                        </form>
                        <?php
                    }
                    ?>

                </div>
                <div class="card-header">
                    <?php
                    $username = $_SESSION['username'];
                    $fetchUsers = "SELECT * FROM users WHERE username = '$username'";
                    $searchUsers = mysqli_query($renzo, $fetchUsers);
                    $results = mysqli_fetch_assoc($searchUsers);
                    ?>
                    <p><?= $results['fname'] . ' ' . $results['lname'] ?></p>
                    <p>@<?= $_SESSION['username'] ?></p>
                </div>
                <hr>
                <div class="card-body">
                    <p><strong>Email Address:</strong> <?= $results['email'] ?></p>
                </div>
            </div>
        </div>

        <div id="feedbackModal">
            <div class="card-header">
                <h1>Feedback</h1>
            </div>
            <div class="card">
                <form action="../server/tomaraoMethod.php" method="post" id="feedbackForm">
                    <div class="form-floating">
                        <input type="text" class="input-fields" name="username" id="username"
                            value="<?= $_SESSION['username'] ?>" disabled>
                        <label for="username">Username</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" class="input-fields" name="subject" id="subject" required>
                        <label for="subject">Subject</label>
                    </div>
                    <div class="form-floating">
                        <textarea type="text" class="input-fields" name="message" id="message" required></textarea>
                        <label for="message">Message</label>
                    </div>
                    <button type="submit" class="admin-btns" name="feedback">Send</button>
                </form>
            </div>
        </div>
        <?php
    }
    ?>

    <div class=" add-school" popover id="addSchool">
        <h1 style="text-align: center; margin-bottom: 1em;">School Information</h1>
        <form action="../server/tomaraoMethod.php" method="post" autocomplete="off" id="schoolForm"
            enctype="multipart/form-data">
            <div class="form-floating">
                <input type="file" class="file-fields" name="logo[]" id="logo" placeholder="School Logo"
                    accept=".jpg, .jpeg, .png, .webp">

                <label for="logo">School Logo</label>
            </div>
            <input type="text" class="input-fields" name="schoolName" placeholder="Name of School">
            <input type="number" class="input-fields" name="schoolNumber" id="number" placeholder="Contact Number"
                oninput="if (this.value.length > 11) this.value = this.value.slice(0, 11)"
                onkeypress="return event.charCode >= 48 && event.charCode <= 57">

            <input type="text" class="input-fields" name="schoolLocation" placeholder="School Location">
            <button type="submit" name="addSchool" class="renzo-primary-btn">Submit</button>
        </form>
    </div>
</body>

</html>

<?php
if (isset($_POST['deactivate'])) {
    $username = $_POST['username'];

    $updateType = "UPDATE users SET type = 2 WHERE username = '$username'";
    if (mysqli_query($renzo, $updateType)) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Account deactivated.';
        echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('success'); </script>";
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Please try again later.';
        echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('failed'); </script>";
        exit();
    }
}
if (isset($_POST['reactivate'])) {
    $username = $_POST['username'];

    $updateType = "UPDATE users SET type = 0 WHERE username = '$username'";
    if (mysqli_query($renzo, $updateType)) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Account reactivated.';
        echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('success'); </script>";
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Please try again later.';
        echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('failed'); </script>";
        exit();
    }
}
?>