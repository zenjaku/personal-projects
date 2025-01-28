<?php
// session_start();

// // Database connections (adjust as needed)
// $dbHost = 'localhost';
// $dbUser = 'root';
// $dbPass = '';
// $dbName = 'hpl';

// if (isset($_GET['export'])) {
// include('../server/connections.php');

// Define the backup folder path
$backupFolder = $_SERVER['DOCUMENT_ROOT'] . '/database/';

// Ensure the directory exists or create it
if (!is_dir($backupFolder)) {
    mkdir($backupFolder, 0777, true);
}

$backupFile = $backupFolder . $db . 'database_export_' . date('Y-m-d_H-i-s') . '.sql'; // Save in the database folder
$tables = $conn->query("SHOW TABLES");

if (!$tables) {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Error fetching table information';
    echo "<script> window.location = 'index.php?page=inventory'; </script>";
    exit();
}

$sqlDump = "";

// Generate SQL dump
while ($row = $tables->fetch_row()) {
    $tableName = $row[0];
    $createTable = $conn->query("SHOW CREATE TABLE `$tableName`")->fetch_row()[1];
    $sqlDump .= "$createTable;\n\n";

    $result = $conn->query("SELECT * FROM `$tableName`");
    while ($data = $result->fetch_assoc()) {
        $values = array_map(function ($value) use ($conn) {
            return "'" . $conn->real_escape_string($value) . "'";
        }, array_values($data));

        $columns = implode("`, `", array_keys($data));
        $valuesString = implode(", ", $values);
        $sqlDump .= "INSERT INTO `$tableName` (`$columns`) VALUES ($valuesString);\n";
    }
    $sqlDump .= "\n\n";
}

// Save the SQL dump to the backup folder
if (file_put_contents($backupFile, $sqlDump) !== false) {
    $_SESSION['status'] = 'success';
    $_SESSION['success'] = "Database exported successfully to: $backupFile";
} else {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'Failed to write the database export file';
}
echo "<script> window.location = 'index.php?page=inventory'; </script>";
exit();
// }


// if (isset($_GET['export'])) {
//     include('../server/connections.php');

//     $backupFile = 'db_export_' . date('Y-m-d_H-i-s') . '.sql'; // Add a timestamp to the file
//     $tables = $conn->query("SHOW TABLES");

//     if (!$tables) {
//         $_SESSION['status'] = 'failed';
//         $_SESSION['failed'] = 'Error fetching table information';
//         header('Location: /index.php?page=db');
//         exit();
//     }

//     $sqlDump = "";

//     // Generate SQL dump
//     while ($row = $tables->fetch_row()) {
//         $tableName = $row[0];
//         $createTable = $conn->query("SHOW CREATE TABLE `$tableName`")->fetch_row()[1];
//         $sqlDump .= "$createTable;\n\n";

//         $result = $conn->query("SELECT * FROM `$tableName`");
//         while ($data = $result->fetch_assoc()) {
//             $values = array_map(function ($value) use ($conn) {
//                 return "'" . $conn->real_escape_string($value) . "'";
//             }, array_values($data));

//             $columns = implode("`, `", array_keys($data));
//             $valuesString = implode(", ", $values);
//             $sqlDump .= "INSERT INTO `$tableName` (`$columns`) VALUES ($valuesString);\n";
//         }
//         $sqlDump .= "\n\n";
//     }

//     if (file_put_contents($backupFile, $sqlDump) !== false) {
//         $_SESSION['status'] = 'success';
//         $_SESSION['success'] = "Database exported successfully: $backupFile";
//     } else {
//         $_SESSION['status'] = 'failed';
//         $_SESSION['failed'] = 'Failed to write the database export file';
//     }

//     header('Location: /index.php?page=db');
//     exit();
// }

// if (isset($_POST['import'])) {
//     if (!empty($_FILES['sql_file']['tmp_name'])) {
//         $file = $_FILES['sql_file']['tmp_name'];

//         // Run mysql command to import the SQL file
//         $command = sprintf(
//             'mysql -h%s -u%s -p%s %s < %s',
//             escapeshellarg($dbHost),
//             escapeshellarg($dbUser),
//             escapeshellarg($dbPass),
//             escapeshellarg($dbName),
//             escapeshellarg($file)
//         );

//         exec($command, $output, $return_var);

//         if ($return_var === 0) {
//             $_SESSION['status'] = 'success';
//             $_SESSION['success'] = 'Database imported successfully';
//         } else {
//             $_SESSION['status'] = 'failed';
//             $_SESSION['failed'] = 'Error in importing database. Please try again.';
//         }
//     } else {
//         $_SESSION['status'] = 'failed';
//         $_SESSION['failed'] = 'Please upload a valid SQL file';
//     }

//     header('Location: /index.php?page=db');
//     exit();
// }

// //import or export db
// if (isset($_GET['export'])) {
//     // $host = 'localhost';
//     // $dbname = 'your_database_name';
//     // $username = '';
//     // $password = '';

//     // $backupFile = 'db_export.sql';
//     // $connection = new mysqli($host, $username, $password, $dbname);

//     // if ($connection->connect_error) {
//     //     die("Connection failed: " . $connection->connect_error);
//     // }

//     include('server/connections.php');

//     $tables = $conn->query("SHOW TABLES");
//     $sqlDump = "";

//     while ($row = $tables->fetch_row()) {
//         $tableName = $row[0];
//         $createTable = $conn->query("SHOW CREATE TABLE `$tableName`")->fetch_row()[1];
//         $sqlDump .= "$createTable;\n\n";

//         $result = $conn->query("SELECT * FROM `$tableName`");
//         while ($data = $result->fetch_assoc()) {
//             $values = array_map(function ($value) use ($conn) {
//                 return "'" . $conn->real_escape_string($value) . "'";
//             }, array_values($data));

//             $columns = implode("`, `", array_keys($data));
//             $valuesString = implode(", ", $values);
//             $sqlDump .= "INSERT INTO `$tableName` (`$columns`) VALUES ($valuesString);\n";
//         }
//         $sqlDump .= "\n\n";
//     }

//     file_put_contents($backupFile, $sqlDump);
//     // echo "Database export completed: $backupFile";
//     $_SESSION['status'] = 'success';
//     $_SESSION['success'] = 'Exported successfully ' . $backupFile;
//     echo "<script> window.location = 'index.php?page=db'; </script>";
//     exit();
// }

// if (isset($_POST['import'])) {
//     $dbHost = 'localhost'; // Database host
//     $dbUser = 'root'; // Database username
//     $dbPass = ''; // Database password
//     $dbName = "hpl"; // Database name (set correctly)

//     $file = $_FILES['sql_file']['tmp_name'];

//     if (!empty($file)) {
//         set_time_limit(0); // No time limit
//         ini_set('memory_limit', '512M'); // Adjust memory limit as needed

//         // Run mysql command to import the SQL file
//         $command = "mysql -h$dbHost -u$dbUser -p$dbPass $dbName < $file";

//         exec($command, $output, $return_var);

//         if ($return_var === 0) {
//             $_SESSION['status'] = 'success';
//             $_SESSION['success'] = 'Imported successfully';
//             echo "<script> window.location = 'index.php?page=db'; </script>";
//             exit();
//         } else {
//             $_SESSION['status'] = 'failed';
//             $_SESSION['failed'] = 'Error in importing database, please try again later';
//             echo "<script> window.location = 'index.php?page=db'; </script>";
//             exit();
//         }
//     } else {
//         $_SESSION['status'] = 'failed';
//         $_SESSION['failed'] = 'Please upload a valid SQL file';
//         echo "<script> window.location = 'index.php?page=db'; </script>";
//         exit();
//     }
// }
?>