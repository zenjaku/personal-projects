<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load dependencies (fix path to match your directory structure)
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['e-signature'])) {
    $employee_id = $_GET['employee_id'];
    $file = $_FILES['e-signature'];

    // echo $employee_id;
    // // Debug: Print employee_id
    echo "<script>console.log('Employee ID:', " . json_encode($employee_id) . ");</script>";

    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png'];

        if (in_array($fileExtension, $allowedTypes)) {
            try {
                // Upload to Cloudinary
                $upload = $cloudinary->uploadApi()->upload($file['tmp_name'], [
                    'folder' => 'users/' . $_SESSION['user_id'] . '/signatures/'
                ]);
                $imageUrl = $upload['secure_url'];

                // Debug: Print URL and ID
                echo "<script>console.log('URL to Save:', '$imageUrl');</script>";
                echo "<script>console.log('Employee ID:', '$employee_id');</script>";

                // Update database
                $stmt = $conn->prepare("UPDATE employee SET signature = ? WHERE employee_id = ?");
                if (!$stmt) {
                    die("Prepare failed: " . $conn->error);
                }

                $stmt->bind_param("si", $imageUrl, $employee_id); // Use "si" for string + integer
                
                if ($stmt->execute()) {
                    $_SESSION['success'] = 'Image uploaded successfully!';
                } else {
                    $_SESSION['failed'] = "Database error: " . $stmt->error;
                }

                // Redirect
                echo "<script>window.location = '/inventory-custody?employee_id=$employee_id';</script>";
                exit();

            } catch (Exception $e) {
                $_SESSION['failed'] = 'Cloudinary error: ' . $e->getMessage();
                echo "<script>window.location = '/inventory-custody?employee_id=$employee_id';</script>";
                exit();
            }
        }
    }
}
?>