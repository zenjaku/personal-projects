<?php
// Enable error reporting for development (in production, you can disable this)
error_reporting(E_ALL);
ini_set('display_errors', 0);  // Don't display errors to users

// Load dependencies
require_once __DIR__ . '/../vendor/autoload.php';  // Adjusted path
include 'server/connections.php';

// Add Cloudinary class imports
use Cloudinary\Cloudinary;
use Cloudinary\Uploader;

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Load environment variables
Dotenv\Dotenv::createImmutable(__DIR__ . '/../admin')->load();

// Configure Cloudinary (now accessible via the use statement)
$cloudinary = new Cloudinary([
    'cloud' => [
        'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
        'api_key' => $_ENV['CLOUDINARY_API_KEY'],
        'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
    ],
    'url' => ['secure' => true]
]);

// Function to log errors into a file
function logError($message)
{
    $logFile = __DIR__ . '/server/upload_errors.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message" . PHP_EOL, FILE_APPEND);
}

// Function to handle file upload (both for employee and admin)// Function to handle file upload (both for employee and admin)
function handleFileUpload($file, $id, $type)
{
    global $conn, $cloudinary;

    // Check if there was an upload error
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedTypes)) {
            try {
                // Attempt to upload to Cloudinary
                $upload = $cloudinary->uploadApi()->upload($file['tmp_name'], [
                    'folder' => "$type/" . $_SESSION['user_id'] . '/signatures/'
                ]);
                $imageUrl = $upload['secure_url'];

                // Update database with Cloudinary URL
                if ($type == 'users') {
                    $stmt = $conn->prepare("UPDATE $type SET signature = ? WHERE username = ?");
                    $stmt->bind_param("ss", $imageUrl, $id);  // Bind string for both
                } else {
                    $stmt = $conn->prepare("UPDATE $type SET signature = ? WHERE {$type}_id = ?");
                    $stmt->bind_param("si", $imageUrl, $id);  // Bind string and integer for employees
                }

                if ($stmt->execute()) {
                    $_SESSION['success'] = 'Image uploaded successfully to Cloudinary!';
                } else {
                    $_SESSION['failed'] = "Database error: " . $stmt->error;
                }

            } catch (Exception $e) {
                // Log Cloudinary error
                logError("Cloudinary upload failed for $type $id: " . $e->getMessage());

                // Backup: Save locally if Cloudinary fails
                $uploadDir = __DIR__ . '/server/signature/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $newFileName = $id . '_' . date('Y-m-d_H-i-s') . '.' . $fileExtension;
                $targetPath = $uploadDir . $newFileName;

                // Move file to the backup directory
                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $localImageUrl = '/server/signature/' . $newFileName;

                    // Update database with the local file URL
                    if ($type == 'users') {
                        $stmt = $conn->prepare("UPDATE $type SET signature = ? WHERE username = ?");
                        $stmt->bind_param("ss", $localImageUrl, $id);  // Bind string for both
                    } else {
                        $stmt = $conn->prepare("UPDATE $type SET signature = ? WHERE {$type}_id = ?");
                        $stmt->bind_param("si", $localImageUrl, $id);  // Bind string and integer for employees
                    }

                    if ($stmt->execute()) {
                        $_SESSION['success'] = 'Image uploaded successfully and saved locally as backup!';
                    } else {
                        // Log database error for local upload
                        logError("Database error while updating local signature for $type $id: " . $stmt->error);
                        $_SESSION['failed'] = 'Failed to save signature in the database!';
                    }
                } else {
                    // Log file system error
                    logError("Failed to upload file to server for $type $id.");
                    $_SESSION['failed'] = 'Failed to upload signature locally!';
                }
            }

        } else {
            // Log invalid file type error
            logError("Invalid file type uploaded for $type $id: $fileExtension");
            $_SESSION['failed'] = 'Invalid file type. Only JPG, JPEG, and PNG are allowed!';
        }
    } else {
        // Log upload error
        logError("File upload error for $type $id: " . $file['error']);
        $_SESSION['failed'] = 'There was an error uploading the file!';
    }
}


// Handle Employee Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['e-signature'])) {
    $employee_id = $_GET['employee_id'];
    $file = $_FILES['e-signature'];
    handleFileUpload($file, $employee_id, 'employee');
    // Redirect after upload
    echo "<script>window.location = '/inventory-custody?employee_id=$employee_id';</script>";
    exit();
}

// Handle Admin Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['a-signature'])) {
    $username = $_GET['username'];
    $file = $_FILES['a-signature'];
    handleFileUpload($file, $username, 'users');
    // Redirect after upload
    echo "<script>window.location = '/inventory-custody;</script>";
    exit();
}
?>