<?php
include_once '../auth/config-local.php';
session_start(); // Ensure session is started

// Ensure $conn is initialized and connected to the database
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Function to log errors
function logError($message)
{
    error_log($message);
}

// Auto-create the 'users' table if it doesn't exist
$createTable = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    type INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($createTable)) {
    logError("Error creating users table: " . $conn->error);
}

// Create other tables with error logging
$tables = [
    "partner" => "
    CREATE TABLE IF NOT EXISTS partner (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) UNIQUE NOT NULL,
        fname VARCHAR(255) NOT NULL,
        lname VARCHAR(255) NOT NULL,
        date VARCHAR(255) NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "album" => "
    CREATE TABLE IF NOT EXISTS album (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) UNIQUE NOT NULL,
        carousel_images VARCHAR(1500) NULL,
        overlay_images VARCHAR(1500) NULL,
        details_images VARCHAR(1500) NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "event" => "
    CREATE TABLE IF NOT EXISTS event (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) UNIQUE NOT NULL,
        event_title VARCHAR(255) NULL,
        event_images VARCHAR(255) NULL,
        event_details TEXT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "google" => "
    CREATE TABLE IF NOT EXISTS google (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) UNIQUE NOT NULL,
        wed_place TEXT NULL,
        map_wed TEXT NULL,
        rep_place TEXT NULL,
        map_rep TEXT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "details" => "
    CREATE TABLE IF NOT EXISTS details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) UNIQUE NOT NULL,
        story TEXT NULL,
        rsvp_message TEXT NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",
    "guests" => "
    CREATE TABLE IF NOT EXISTS guests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        fname VARCHAR(255) NULL,
        lname VARCHAR(255) NULL,
        response VARCHAR(150) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )"
];

foreach ($tables as $name => $query) {
    if (!$conn->query($query)) {
        logError("Error creating $name table: " . $conn->error);
    }
}

if (isset($_POST['register'])) {
    // Check if a user already exists
    $checkExistingUser = "SELECT COUNT(*) FROM users";
    $result = $conn->query($checkExistingUser);
    $row = $result->fetch_row();

    if ($row[0] > 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Registration is closed. Only one user can register at a time.';
        header("Location: /index.php?page=login");
        exit();
    }

    $fname = trim($_REQUEST['fname']);
    $lname = trim($_REQUEST['lname']);
    $email = trim($_REQUEST['email']);
    $username = trim($_REQUEST['username']);
    $password = $_REQUEST['password'];
    $confirmPassword = $_REQUEST['confirmPassword'];
    $type = 1;

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Passwords do not match.';
        header("Location: /index.php?page=login");
        exit();
    }

    // Check if email already exists
    $checkEmail = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($checkEmail);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'The email ' . htmlspecialchars($email) . ' is already registered, please sign in to continue.';
        header("Location: /index.php?page=login");
        exit();
    }

    // Check if username already exists
    $checkUsername = "SELECT username FROM users WHERE username = ?";
    $stmt = $conn->prepare($checkUsername);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'The username ' . htmlspecialchars($username) . ' is already taken. Please choose another one.';
        header("Location: /index.php?page=login");
        exit();
    }

    // Hash the password securely
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $register = "INSERT INTO users (fname, lname, email, username, password, type) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($register);
    $stmt->bind_param("sssssi", $fname, $lname, $email, $username, $hashedPassword, $type);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = 'Registration successful! Please log in.';
        header("Location: /index.php?page=login");
        exit();
    } else {
        logError("Error registering user: " . $stmt->error);
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Registration failed. Please try again.';
        header("Location: /index.php?page=login");
        exit();
    }
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare the statement to prevent SQL injection
    // Use BINARY to make the username comparison case-sensitive
    $stmt = $conn->prepare("SELECT * FROM users WHERE BINARY username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['status'] = "success";
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Welcome back, " . htmlspecialchars($user['fname']);

            // Redirect based on user type
            $_SESSION['type'] = $user['type'];
            header("Location: " . ($user['type'] === 1 ? "/index.php?page=admin" : "/index.php?page=home"));
            exit();
        } else {
            $_SESSION['status'] = "failed";
            $_SESSION['failed'] = "Invalid username or password.";
            header("Location: /index.php?page=login");
            exit();
        }
    } else {
        $_SESSION['status'] = "failed";
        $_SESSION['failed'] = "Username not found.";
        header("Location: /index.php?page=login");
        exit();
    }
}

if (isset($_POST["partner"])) {
    $username = $_SESSION['username'];
    $fname = trim($_REQUEST['fname']);
    $lname = trim($_REQUEST['lname']);
    $date = trim($_REQUEST['wedding-date']);

    $save = "INSERT INTO partner (username, fname, lname, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($save);
    $stmt->bind_param("ssss", $username, $fname, $lname, $date);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = "Partner's information saved successfully.";
        header("Location: /index.php?page=admin");
    } else {
        logError("Error saving partner information: " . $stmt->error);
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to save partner information. Please try again.';
        header("Location: /index.php?page=admin");
    }
    exit();
}

if (isset($_POST["details"])) {
    $username = $_SESSION["username"];
    $story = trim($_REQUEST["story"]);
    $rsvp_message = trim($_REQUEST["rsvp-message"]);

    $details = "INSERT INTO details (username, story, rsvp_message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($details);
    $stmt->bind_param("sss", $username, $story, $rsvp_message);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = "Details saved successfully.";
        header("Location: /admin");
    } else {
        logError("Error saving details: " . $stmt->error);
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to save details. Please try again.';
        header("Location: /index.php?page=admin");
    }
    exit();
}

if (isset($_POST['upload-photo'])) {
    $username = $_SESSION['username'];

    // Function to handle file uploads
    function handleFileUpload($fileInputName, $username)
    {
        $filePaths = [];
        $uploadDir = 'uploads/'; // Ensure this directory exists and is writable

        // Create the upload directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create directory with appropriate permissions
        }

        // Check if the upload directory is writable
        if (!is_writable($uploadDir)) {
            logError("Upload directory is not writable.");
            return $filePaths;
        }

        foreach ($_FILES[$fileInputName]['name'] as $key => $name) {
            if ($_FILES[$fileInputName]['error'][$key] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$fileInputName]['tmp_name'][$key];
                $filePath = $uploadDir . $username . '_' . basename($name); // Prefix with username
                if (move_uploaded_file($tmpName, $filePath)) {
                    $filePaths[] = $filePath;
                } else {
                    logError("Failed to move uploaded file: " . $name);
                }
            } else {
                logError("File upload error: " . $_FILES[$fileInputName]['error'][$key]);
            }
        }
        return $filePaths;
    }

    $carousel = serialize(handleFileUpload('carousel-images', $username));
    $overlayBg = serialize(handleFileUpload('overlay-images', $username));
    $details = serialize(handleFileUpload('details-images', $username));

    $upload = "INSERT INTO album (username, carousel_images, overlay_images, details_images) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($upload);
    $stmt->bind_param("ssss", $username, $carousel, $overlayBg, $details);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = "Images uploaded successfully.";
        header("Location: /index.php?page=admin");
    } else {
        logError("Error uploading images: " . $stmt->error);
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to upload images. Please try again.';
        header("Location: /index.php?page=admin");
    }
    exit();
}

if (isset($_POST['submit-event'])) {
    // Check if 'event-images' is set in $_FILES
    if (!isset($_FILES['event-images'])) {
        logError("No files uploaded for event-images.");
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'No images uploaded. Please try again.';
        header("Location: /index.php?page=admin");
        exit();
    }

    $username = $_SESSION['username'];
    $event_details = trim($_REQUEST["event-details"]);
    $event_title = trim($_REQUEST["event-header"]); // Changed to match the form name

    // Function to handle file uploads
    function handleFileUpload($fileInputName, $username)
    {
        $filePaths = [];
        $uploadDir = 'uploads/'; // Ensure this directory exists and is writable

        // Create the upload directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create directory with appropriate permissions
        }

        // Check if the upload directory is writable
        if (!is_writable($uploadDir)) {
            logError("Upload directory is not writable.");
            return $filePaths;
        }

        foreach ($_FILES[$fileInputName]['name'] as $key => $name) {
            if ($_FILES[$fileInputName]['error'][$key] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES[$fileInputName]['tmp_name'][$key];
                $filePath = $uploadDir . $username . '_' . basename($name); // Prefix with username
                if (move_uploaded_file($tmpName, $filePath)) {
                    $filePaths[] = $filePath;
                } else {
                    logError("Failed to move uploaded file: " . $name);
                }
            } else {
                logError("File upload error: " . $_FILES[$fileInputName]['error'][$key]);
            }
        }
        return $filePaths;
    }

    $event = serialize(handleFileUpload('event-images', $username));

    $upload = "INSERT INTO event (username, event_title, event_images, event_details) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($upload);
    $stmt->bind_param("ssss", $username, $event_title, $event, $event_details);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = "Event details submitted successfully.";
        header("Location: /index.php?page=admin");
    } else {
        logError("Error uploading images: " . $stmt->error);
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to submit event details. Please try again.';
        header("Location: /index.php?page=admin");
    }
    exit();
}

if (isset($_POST['google-map'])) {
    $username = $_SESSION['username'];
    $wed_place = trim(string: $_REQUEST['wed-place']);
    $map_wed = trim($_REQUEST['map-link-wed']);
    $rep_place = trim(string: $_REQUEST['rep-place']);
    $map_rep = trim($_REQUEST['map-link-rep']);

    $google = "INSERT INTO google (username, map_wed, map_rep, wed_place, rep_place) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($google);
    $stmt->bind_param("sssss", $username, $map_wed, $map_rep, $wed_place, $rep_place);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = "Event place saved successfully.";
        header("Location: /index.php?page=admin");
    } else {
        logError("Error saving Event place: " . $stmt->error);
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to save event place. Please try again.';
        header("Location: /index.php?page=admin");
    }
    exit();
}

if (isset($_POST["guest-register"])) {
    $username = $_SESSION["username"];
    $fname = trim($_REQUEST["g-fname"]);
    $lname = trim($_REQUEST["g-lname"]);

    $guest = "INSERT INTO guests (username, fname, lname) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($guest);
    $stmt->bind_param("sss", $username, $fname, $lname);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = "Guest registered successfully.";
        header("Location: /index.php?page=admin");
    } else {
        logError("Error registering guest: " . $stmt->error);
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to register guest. Please try again.';
        header("Location: /index.php?page=admin");
    }
    exit();
}
if (isset($_POST["rsvp-response"])) {
    // Check if guestId is set in the session
    if (!isset($_SESSION["guestId"])) {
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Session expired. Please check your invitation and try again.';
        header("Location: /index.php?page=rsvp");
        exit();
    }

    $guestId = $_SESSION["guestId"];
    $response = trim($_POST["response"]);
    $updateResponse = "UPDATE guests SET response = ? WHERE id = ?";
    $stmt = $conn->prepare($updateResponse);
    $stmt->bind_param("si", $response, $guestId);
    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['success'] = "Thank you for your response.";
        header("Location: /index.php?page=home");
        unset($_SESSION["guest"], $_SESSION["guestId"]);
        exit();
    } else {
        logError("Error updating response: " . $stmt->error);
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = 'Failed to submit the response. Please try again.';
        header("Location: /index.php?page=rsvp");
    }
    exit();
}

if (isset($_POST['check-guest'])) {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);

    // Check if the guest exists based on the provided name
    $checkName = "SELECT * FROM guests WHERE fname = ? AND lname = ?";
    $stmt = $conn->prepare($checkName);
    $stmt->bind_param("ss", $fname, $lname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) { // No guest found
        $_SESSION['status'] = 'failed';
        $_SESSION['failed'] = "We apologize, but it seems you are not on the list. Please contact the groom or bride for further clarification. Thank you!";
        header("Location: /index.php?page=rsvp");
        exit();
    } else {
        $guestData = $result->fetch_assoc();
        $_SESSION["guest"] = $guestData["fname"];
        $_SESSION["guestId"] = $guestData["id"];
        header("Location: /index.php?page=rsvp-form");
        exit();
    }
}

if (isset($_POST["google-update"])) {
    $username = $_SESSION['username'];
    $wed_place = trim($_REQUEST['wed-place']);
    $map_wed = trim($_REQUEST['map-link-wed']);
    $rep_place = trim($_REQUEST['rep-place']);
    $map_rep = trim($_REQUEST['map-link-rep']);

    // Prepare the update query
    $updateFields = [];
    $params = [];

    if (!empty($map_wed)) {
        $updateFields[] = "map_wed = ?";
        $params[] = $map_wed;
    }
    if (!empty($map_rep)) {
        $updateFields[] = "map_rep = ?";
        $params[] = $map_rep;
    }
    if (!empty($wed_place)) {
        $updateFields[] = "wed_place = ?";
        $params[] = $wed_place;
    }
    if (!empty($rep_place)) {
        $updateFields[] = "rep_place = ?";
        $params[] = $rep_place;
    }

    // Check if there are fields to update
    if (count($updateFields) > 0) {
        $sql = "UPDATE google SET " . implode(", ", $updateFields) . " WHERE username = ?";
        $params[] = $username; // Add username to the parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat("s", count($params)), ...$params); // Bind parameters

        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = "Event place updated successfully.";
        } else {
            logError("Error saving event place: " . $stmt->error);
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Failed to update event place. Please try again.';
        }
    } else {
        $_SESSION['status'] = 'info';
        $_SESSION['info'] = 'No updates were made.';
    }
    header("Location: /index.php?page=admin");
    exit();
}

if (isset($_POST["details-update"])) {
    $username = $_SESSION['username'];
    $story = trim($_REQUEST['story']);
    $rsvp_message = trim($_REQUEST['rsvp-message']);

    // Prepare the update query
    $updateFields = [];
    $params = [];

    if (!empty($story)) {
        $updateFields[] = "story = ?";
        $params[] = $story;
    }
    if (!empty($rsvp_message)) {
        $updateFields[] = "rsvp_message = ?";
        $params[] = $rsvp_message;
    }

    // Check if there are fields to update
    if (count($updateFields) > 0) {
        $sql = "UPDATE details SET " . implode(", ", $updateFields) . " WHERE username = ?";
        $params[] = $username; // Add username to the parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat("s", count($params)), ...$params); // Bind parameters

        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = "Details updated successfully.";
        } else {
            logError("Error saving details place: " . $stmt->error);
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Failed to update details place. Please try again.';
        }
    } else {
        $_SESSION['status'] = 'info';
        $_SESSION['info'] = 'No updates were made.';
    }
    header("Location: /index.php?page=admin");
    exit();

}

if (isset($_POST["partner-update"])) {
    $username = $_SESSION['username'];
    $fname = trim($_REQUEST['fname']);
    $lname = trim($_REQUEST['lname']);
    $date = trim($_REQUEST['wedding-date']);

    // Prepare the update query
    $updateFields = [];
    $params = [];

    if (!empty($fname)) {
        $updateFields[] = "fname = ?";
        $params[] = $fname;
    }
    if (!empty($lname)) {
        $updateFields[] = "lname = ?";
        $params[] = $lname;
    }
    if (!empty($date)) {
        $updateFields[] = "date = ?";
        $params[] = $date;
    }

    // Check if there are fields to update
    if (count($updateFields) > 0) {
        $sql = "UPDATE partner SET " . implode(", ", $updateFields) . " WHERE username = ?";
        $params[] = $username; // Add username to the parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat("s", count($params)), ...$params); // Bind parameters

        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['success'] = "Partner's details updated successfully.";
        } else {
            logError("Error saving partner's details place: " . $stmt->error);
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = "Failed to update partner's details place. Please try again.";
        }
    } else {
        $_SESSION['status'] = 'info';
        $_SESSION['info'] = 'No updates were made.';
    }
    header("Location: /index.php?page=admin");
    exit();

}