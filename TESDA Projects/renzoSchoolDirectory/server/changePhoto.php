<?php
include_once "tomaraoConnection.php";
session_start();

$username = $_GET['username'];

function handleFileUpload($fileInputName, $username)
{
    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES[$fileInputName]['tmp_name'];
        $fileName = $username . '_' . basename($_FILES[$fileInputName]['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $filePath)) {
            return $filePath;
        }
    }
    return false;
}

$profile_photo = handleFileUpload('profile-photo', $username);

if ($profile_photo) {
    $profile_photo_serialized = serialize([$profile_photo]);
    $updatePhoto = "UPDATE photos SET profile_photo = '$profile_photo_serialized' WHERE username = '$username'";

    if (mysqli_query($renzo, $updatePhoto)) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Profile photo successfully saved.';
        echo "<script>window.location.href = '../views/tomaraoDashboard.php';</script>";
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Please try again later.';
        echo "<script>window.location.href = '../views/tomaraoDashboard.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Change Photo</title>
</head>

<body>
    <div class="card" id="profileModal" style="margin-top: 2em;">
        <div class="profile-picture">
            <form action="" method="post" enctype="multipart/form-data" id="profilePhotoForm">
                <div class="form-floating">
                    <input type="file" name="profile-photo" id="profilePhoto" accept=".jpeg, .jpg, .png">
                    <label for="profilePhoto">Profile Photo</label>
                </div>
                <button class="renzo-primary-btn" type="submit">Save</button>
            </form>
        </div>
    </div>
</body>

</html>
