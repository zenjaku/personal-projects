<?php
include_once('connection.php');
session_start();

// Check if form is submitted
if (isset($_POST["SUBMIT"])) {
    // Validate and sanitize input fields
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $sub = mysqli_real_escape_string($conn, $_POST['sub'] ?? '');
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
    $sizes = isset($_POST['sizes']) ? implode(",", $_POST['sizes']) : '';
    $bestSeller = filter_var($_POST['bestSeller'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false';

    // Validate required fields
    if (empty($sub) || empty($category)) {
        echo "<script>
                alert('Please select all required fields.');
                window.history.back();
              </script>";
        exit;
    }

    // Directory to store uploaded images
    $target_dir = "../assets/";
    $uploaded_images = [];
    $error_messages = [];

    // Loop through each uploaded image
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['images']['name'][$key]);

        // Ignore empty inputs
        if ($_FILES['images']['error'][$key] === UPLOAD_ERR_NO_FILE) {
            continue;
        }

        // Check for valid upload
        if ($_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $uploaded_images[] = $target_file;
            } else {
                $error_messages[] = "Failed to upload image: $file_name";
            }
        } else {
            $error_messages[] = "Error uploading image: $file_name - Error code: " . $_FILES['images']['error'][$key];
        }
    }

    // Convert images to comma-separated string
    $imageUrl = implode(",", $uploaded_images);

    // Insert data only if no upload errors
    if (empty($error_messages)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO product (productName, description, price, imageUrl, sizes, category, sub, bestSeller)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsssss", $productName, $description, $price, $imageUrl, $sizes, $category, $sub, $bestSeller);

        if ($stmt->execute()) {
            $_SESSION['status'] = 'saved';
            $_SESSION['saved'] = "$productName added successfully";
            header('Location: ../index.php?page=admin');
            exit();
        } else {
            $_SESSION['status'] = 'failedSaved';
            $_SESSION['failedSaved'] = "Failed to add $productName";
            header('Location: ../index.php?page=admin');
            exit();
        }
    }

    // Display error messages if any
    if (!empty($error_messages)) {
        foreach ($error_messages as $error) {
            echo "<script> 
                    alert('$error');
                    parent.location.href = '../index.php?page=admin'; 
                  </script>";
        }
    }
}
