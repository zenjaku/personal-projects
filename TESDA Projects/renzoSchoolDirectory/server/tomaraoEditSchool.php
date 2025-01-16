<?php
session_start();
include 'tomaraoConnection.php';

if (isset($_POST['update'])) {
    $school_id = $_GET['school_id'];
    $schoolName = $_POST['schoolName'];
    $schoolNumber = $_POST['schoolNumber'];
    $schoolLocation = $_POST['schoolLocation'];

    // Handle file upload
    function handleFileUpload($fileInputName)
    {
        $uploadDir = '../server/uploads/';
        $filePath = '';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!empty($_FILES[$fileInputName]['name'])) {
            $tmpName = $_FILES[$fileInputName]['tmp_name'];
            $fileName = date('Y-m-d') . '_' . basename($_FILES[$fileInputName]['name']);
            $filePath = $uploadDir . $fileName;

            if (!move_uploaded_file($tmpName, $filePath)) {
                echo "Failed to upload file.";
            }
        }
        return $filePath;
    }

    $logoPath = handleFileUpload('schoolLogo');
    $logoSerialized = !empty($logoPath) ? serialize([$logoPath]) : null;

    // Update query
    $updateSchool = "UPDATE schoolInfo 
                     SET schoolName = '$schoolName', 
                         schoolNumber = '$schoolNumber', 
                         schoolLocation = '$schoolLocation'";
    if ($logoSerialized) {
        $updateSchool .= ", logo = '$logoSerialized'";
    }
    $updateSchool .= " WHERE school_id = '$school_id'";

    $result = mysqli_query($renzo, $updateSchool);

    if ($result) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'School information updated successfully.';
        echo "<script>window.location.href = '../views/tomaraoDashboard.php';</script>";
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to update school information.';
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
    <title>Edit School</title>
</head>

<body>
    <?php
    $school_id = $_GET['school_id'];
    $checkSchool = "SELECT * FROM schoolInfo WHERE school_id = '$school_id'";
    $result = mysqli_query($renzo, $checkSchool);
    $school = mysqli_fetch_assoc($result);
    ?>
    <div class="edit">
        <h1 style="text-align: center; margin-top: 2em;">Edit School Information</h1>
        <?php
        if (!empty($school['logo'])) {
            $logo = unserialize($school['logo']);
            echo '<img src="' . $logo[0] . '" alt="Current Logo" style="max-width: 100px; max-height: 100px; margin-top: 10px;">';
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data" id="editSchool">
            <div class="form-floating">
                <input type="file" class="input-fields" id="schoolLogo" name="schoolLogo" accept=".jpeg, .jpg, .png, .webp">
                <label for="schoolLogo">School Logo:</label>
            </div>
            <div class="form-floating">
                <input type="text" class="input-fields" id="schoolName" name="schoolName"
                    value="<?= $school['schoolName'] ?>" required>
                <label for="schoolName">School Name:</label>
            </div>
            <div class="form-floating">
                <input type="text" class="input-fields" id="schoolNumber" name="schoolNumber"
                    value="<?= $school['schoolNumber'] ?>" required pattern="[0-9]{11}" maxlength="11"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                <label for="schoolNumber">School Number:</label>
            </div>
            <div class="form-floating">
                <input type="text" class="input-fields" id="schoolLocation" name="schoolLocation"
                    value="<?= $school['schoolLocation'] ?>" required>
                <label for="schoolLocation">School Location:</label>
            </div>
            <button type="submit" class="renzo-primary-btn" name="update">Update</button>
            <a href="../views/tomaraoDashboard.php">Cancel</a>
        </form>
    </div>
</body>

</html>