<?php
include('connections.php');

// // Define the backup folder path
// $backupFolder = $_SERVER['DOCUMENT_ROOT'] . '/database/';

// // Ensure the directory exists or create it
// if (!is_dir($backupFolder)) {
//     mkdir($backupFolder, 0777, true);
// }

// $backupFile = $backupFolder . $db . 'database_export_' . date('Y-m-d_H-i-s') . '.sql'; // Save in the database folder
// $tables = $conn->query("SHOW TABLES");

// if (!$tables) {
//     $_SESSION['status'] = 'failed';
//     $_SESSION['failed'] = 'Error fetching table information';
//     header('Location: /index.php?page=register');
//     exit();
// }

// $sqlDump = "";

// // Generate SQL dump
// while ($row = $tables->fetch_row()) {
//     $tableName = $row[0];
//     $createTable = $conn->query("SHOW CREATE TABLE `$tableName`")->fetch_row()[1];
//     $sqlDump .= "$createTable;\n\n";

//     $result = $conn->query("SELECT * FROM `$tableName`");
//     while ($data = $result->fetch_assoc()) {
//         $values = array_map(function ($value) use ($conn) {
//             return "'" . $conn->real_escape_string($value) . "'";
//         }, array_values($data));

//         $columns = implode("`, `", array_keys($data));
//         $valuesString = implode(", ", $values);
//         $sqlDump .= "INSERT INTO `$tableName` (`$columns`) VALUES ($valuesString);\n";
//     }
//     $sqlDump .= "\n\n";
// }

// // Save the SQL dump to the backup folder
// if (file_put_contents($backupFile, $sqlDump) !== false) {
//     $_SESSION['status'] = 'success';
//     $_SESSION['success'] = "Database exported successfully to: $backupFile";
// } else {
//     $_SESSION['status'] = 'failed';
//     $_SESSION['failed'] = 'Failed to write the database export file';
// }

// Logout process: Secure session termination
session_regenerate_id(true); // Prevent session fixation
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to a login or other page after logout
echo "<script> parent.location.href = 'index.php?page=register'; </script>";
exit();
?>