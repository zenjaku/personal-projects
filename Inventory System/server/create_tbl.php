<?php
include_once "connections.php";
// session_start();

// // Create Table Query
// $dataTable = "CREATE TABLE IF NOT EXISTS data_table (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     fname VARCHAR(255) NOT NULL,
//     lname VARCHAR(255) NOT NULL,
//     age VARCHAR(100) NOT NULL,
//     dob DATE NOT NULL,
//     sex VARCHAR(100) NOT NULL,
//     contact VARCHAR(255) NOT NULL,
//     street VARCHAR(255) NOT NULL,
//     brgy VARCHAR(255) NOT NULL,
//     city VARCHAR(255) NOT NULL,
//     province VARCHAR(255) NOT NULL,
//     region VARCHAR(255) NOT NULL,
//     zip VARCHAR(100) NOT NULL,
//     status INT NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
// )";
$createTables = [
    "employee" => "CREATE TABLE IF NOT EXISTS employee (
    employee_id VARCHAR(100) NOT NULL PRIMARY KEY,
    fname VARCHAR(255) NOT NULL,
    lname VARCHAR(255) NOT NULL,
    contact VARCHAR(15) NOT NULL,
    street VARCHAR(255) NOT NULL,
    brgy VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    province VARCHAR(255) NOT NULL,
    region VARCHAR(255) NOT NULL,
    zip VARCHAR(10) NOT NULL,
    status INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",  // Set collation here

    "assets" => "CREATE TABLE IF NOT EXISTS assets (
    assets_id VARCHAR(255) PRIMARY KEY NOT NULL,
    assets VARCHAR(255) NOT NULL,
    brand VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    sn VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",  // Set collation here

    "assets_history" => "CREATE TABLE IF NOT EXISTS assets_history (
    history_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    assets_id VARCHAR(100) NOT NULL,
    employee_id VARCHAR(100) NOT NULL,
    assets VARCHAR(255) NOT NULL,
    sn VARCHAR(255) NOT NULL,
    status INT NOT NULL,
    t_employee_id VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",  // Set collation here

    "allocation" => "CREATE TABLE IF NOT EXISTS allocation (
    allocation_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    assets_id VARCHAR(100) NOT NULL,
    employee_id VARCHAR(100) NOT NULL,
    assets VARCHAR(255) NOT NULL,
    sn VARCHAR(255) NOT NULL,
    status INT NOT NULL,
    t_employee_id VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci",  // Set collation here
];

foreach ($createTables as $name => $tables) {
    if (!$conn->query($tables)) {
        echo "<script> console.log('Failed to create tables.'); </script>";
        die("Error creating data table: " . $conn->error);
    }
}

// Login Logic
// if (isset($_POST['login'])) {
//     $inputUsername = trim($_POST['username']);
//     $inputPassword = trim($_POST['password']);

//     $validUsername = "admin";
//     $validPassword = "12345";

//     if ($inputUsername !== $validUsername) {
//         $_SESSION['status'] = 'failed';
//         $_SESSION['failed'] = 'Incorrect username';
//         header("Location: ../index.php?page=login");
//         exit();
//     }

//     if ($inputPassword !== $validPassword) {
//         $_SESSION['status'] = 'failed';
//         $_SESSION['failed'] = 'Incorrect password';
//         header("Location: ../index.php?page=login");
//         exit();
//     }

//     $_SESSION['login'] = true;
//     $_SESSION['username'] = $validUsername;
//     $_SESSION['status'] = 'success';
//     $_SESSION['success'] = "Welcome, $validUsername";
//     echo "<script> parent.location.href='../index.php'; </script>";
// }


// Adding assets Logic
// if (isset($_POST['register'])) {
//     $fname = trim($_POST['fname']);
//     $lname = trim($_POST['lname']);
//     $age = trim($_POST['age']);
//     $dob = trim($_POST['dob']);
//     $sex = trim($_POST['sex']);
//     $street = trim($_POST['street']);
//     $brgy = trim($_POST['brgy']);
//     $city = trim($_POST['city']);
//     $province = trim($_POST['province']);
//     $region = trim($_POST['region']);
//     $zip = trim($_POST['zip']);
//     $contact = trim($_POST['contact']);
//     $status = trim($_POST['status']);

//     $register = "INSERT INTO data_table (fname, lname, age, dob, sex, street, brgy, city, province, region, zip, contact, status) 
//                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
//     $stmt = $conn->prepare($register);
//     $stmt->bind_param("ssssssssssssi", $fname, $lname, $age, $dob, $sex, $street, $brgy, $city, $province, $region, $zip, $contact, $status);

//     if ($stmt->execute()) {
//         $_SESSION['status'] = 'success';
//         $_SESSION['success'] = 'Information saved successfully';
//         header("Location: ../index.php?page=home");
//         exit();
//     } else {
//         $_SESSION['status'] = 'failed';
//         $_SESSION['failed'] = 'Failed to save information. Please try again.';
//         header("Location: ../index.php?page=register");
//         exit();
//     }
// }

?>