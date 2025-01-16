<?php
include_once 'tomaraoConnection.php';
session_start();

// Create users table
$userTable = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            fname VARCHAR(255) NOT NULL,
            lname VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            username VARCHAR(255) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            type INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

if (!$renzo->query($userTable)) {
    echo "Error Creating users table: " . $renzo->error;
}

$createTables = [
    "schoolInfo" => "CREATE TABLE IF NOT EXISTS schoolInfo (
        school_id VARCHAR(150) PRIMARY KEY,
        logo VARCHAR(255) NOT NULL,
        schoolName VARCHAR(255) UNIQUE NOT NULL,
        schoolNumber VARCHAR(255) NOT NULL,
        schoolLocation VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",

    "archivedSchool" => "CREATE TABLE IF NOT EXISTS archivedSchool (
        archived_id INT AUTO_INCREMENT PRIMARY KEY,
        school_id VARCHAR(150) NOT NULL,
        logo VARCHAR(255) NOT NULL,
        schoolName VARCHAR(255) UNIQUE NOT NULL,
        schoolNumber VARCHAR(255) NOT NULL,
        schoolLocation VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",

    "photos" => "CREATE TABLE IF NOT EXISTS photos (
        photo_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        profile_photo VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",

    "feedback" => "CREATE TABLE IF NOT EXISTS feedback (
        feedback_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",

    "archivedFeedback" => "CREATE TABLE IF NOT EXISTS archivedFeedback (
        archivedFeedback_id INT AUTO_INCREMENT PRIMARY KEY,
        feedback_id INT NOT NULL,
        username VARCHAR(255) NOT NULL,
        subject VARCHAR(255) NOT NULL,
        message VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)"
];

foreach ($createTables as $name => $query) {
    if (!$renzo->query($query)) {
        echo "Error creating $name table: " . $renzo->error;
    }
}

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $type = 0;

    // Check if email exists
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $searchEmail = mysqli_query($renzo, $checkEmail);
    if (mysqli_num_rows($searchEmail) > 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Email Address is not available.';
        echo "<script>window.history.back(); console.log('failed');</script>";
        return;
    }

    // Check if username exists
    $checkUsername = "SELECT * FROM users WHERE username = '$username'";
    $searchUsername = mysqli_query($renzo, $checkUsername);
    if (mysqli_num_rows($searchUsername) > 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Username is not available.';
        echo "<script>window.history.back(); console.log('failed');</script>";
        return;
    }

    // Check if passwords match
    if ($password != $confirmPassword) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Password not matched.';
        echo "<script>window.history.back(); console.log('failed');</script>";
        return;
    }

    // Register user
    $registerUser = "INSERT INTO users (fname, lname, email, username, password, type) VALUES ('$fname', '$lname', '$email', '$username', '$password', '$type')";
    if (mysqli_query($renzo, $registerUser)) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Registered successfully.';
        echo "<script> parent.location.href = '../index.php'; console.log('success'); </script>";
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Please try again later.';
        echo "<script>window.history.back(); console.log('failed');</script>";
        exit();
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login = mysqli_query($renzo, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($login) > 0) {
        $row = mysqli_fetch_assoc($login);

        if((int)$row['type'] == 2) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Account deactivated, please contact administrator for more information.';
            echo "<script> window.location.href = '../views/tomaraoLoginRegister.php'; </script>";
            exit();
        }

        if ($password === $row['password']) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['type'] = $row['type'];
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = 'Welcome Back' . ', ' . $username;

            echo "<script> parent.location.href = '../index.php'; </script>";
            exit();
        } else {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Incorrect password, please try again.';

            echo "<script> window.location.href = '../views/tomaraoLoginRegister.php'; </script>";
            exit();
        }
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Data not found. Please register to continue.';
        echo "<script> window.location.href = '../views/tomaraoLoginRegister.php'; </script>";
        exit();
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    session_unset();
    echo '<script> parent.location.href = "../index.php"; </script>';
    exit();
}

if (isset($_POST['addSchool'])) {
    $schoolName = $_POST['schoolName'];
    $schoolNumber = $_POST['schoolNumber'];
    $schoolLocation = $_POST['schoolLocation'];

    $checkSchoolName = "SELECT * FROM schoolInfo WHERE schoolName = '$schoolName'";
    $searchSchoolName = mysqli_query($renzo, $checkSchoolName);
    if (mysqli_num_rows($searchSchoolName) > 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'School is already saved in the database';
        return;
    }

    function handleFileUpload($fileInputName)
    {
        $filePaths = [];
        $uploadDir = 'uploads/'; // Ensure this directory exists and is writable

        // Create the upload directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create directory with appropriate permissions
        }

        // Check if the upload directory is writable
        if (!is_writable($uploadDir)) {
            echo "Upload directory is not writable.";
            return $filePaths;
        }

        foreach ($_FILES[$fileInputName]['name'] as $key => $name) {
            if ($_FILES[$fileInputName]['error'][$key] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$fileInputName]['tmp_name'][$key];
                $filePath = $uploadDir . date('Y-m-d') . '_' . basename($name);
                if (move_uploaded_file($tmpName, $filePath)) {
                    $filePaths[] = $filePath;
                } else {
                    echo "Failed to move uploaded file: " . $name;
                }
            } else {
                echo "File upload error: " . $_FILES[$fileInputName]['error'][$key];
            }
        }
        return $filePaths;
    }

    $logo = serialize(handleFileUpload('logo', $schoolName));

    do {
        $random = rand(000000, 999999);
        $school_id = date('m-d-Y') . '_' . $random;
        $query = "SELECT COUNT(*) as count FROM schoolInfo WHERE school_id = '$school_id'";
        $result = mysqli_query($renzo, $query);
        $row = mysqli_fetch_assoc($result);
    } while ($row['count'] > 0);

    $addSchool = "INSERT INTO schoolInfo (school_id, logo, schoolName, schoolNumber, schoolLocation)
                VALUES ('$school_id', '$logo', '$schoolName', '$schoolNumber', '$schoolLocation')";

    if (mysqli_query($renzo, $addSchool)) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'School Information successfully saved.';
        echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('success'); </script>";
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Please try again later.';
        echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('failed'); </script>";
        exit();
    }
}
if (isset($_POST['profile-photo'])) {
    $username = $_SESSION['username'];

    function handleFileUpload($fileInputName, $username)
    {
        $uploadDir = 'uploads/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!is_writable($uploadDir)) {
            echo "Upload directory is not writable.";
            return false;
        }

        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES[$fileInputName]['tmp_name'];
            $name = $_FILES[$fileInputName]['name'];
            $filePath = $uploadDir . $username . '_' . basename($name);

            if (move_uploaded_file($tmpName, $filePath)) {
                return $filePath;
            } else {
                echo "Failed to move uploaded file.";
                return false;
            }
        } else {
            echo "File upload error: " . $_FILES[$fileInputName]['error'];
            return false;
        }
    }

    $profile_photo = handleFileUpload('profile-photo', $username);

    if ($profile_photo) {
        $profile_photo_serialized = serialize([$profile_photo]);
        $addPhoto = "INSERT INTO photos (username, profile_photo) VALUES ('$username', '$profile_photo_serialized')";

        if (mysqli_query($renzo, $addPhoto)) {
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = 'Profile photo successfully saved.';

            echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('success'); </script>";
        } else {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Please try again later.';

            echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('failed'); </script>";
            exit();
        }
    } else {
        echo "File upload failed.";
    }
}

if (isset($_POST['feedback'])) {
    $username = $_SESSION['username'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $feedback = "INSERT INTO feedback (username, subject, message) VALUES ('$username', '$subject', '$message')";

    if (mysqli_query($renzo, $feedback)) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Feedback sent.';
        echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('success'); </script>";
    } else {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Please try again later.';
        echo "<script> window.location.href = '../views/tomaraoDashboard.php'; console.log('failed'); </script>";
        exit();
    }
}
