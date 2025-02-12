<?php
require 'vendor/autoload.php';

// Load environment variables
function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        throw new Exception("Environment file not found.");
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// Load .env file
loadEnv(__DIR__ . '/.env');

// MongoDB connection
$mongoUri = $_ENV['MONGO_URI'];
$client = new MongoDB\Client($mongoUri);
$collection = $client->company_logs->file_activity;

// Retrieve session ID (linked to login session)
$sessionIdFile = "C:\\logs\\session_id.txt";
$sessionId = file_exists($sessionIdFile) ? trim(file_get_contents($sessionIdFile)) : "unknown_session";

// Get list of recent file modifications
$directory = "C:\\Users\\" . get_current_user() . "\\Documents"; // Change this if needed
$files = scandir($directory);

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;

    $filePath = $directory . "\\" . $file;
    if (is_file($filePath)) {
        $modifiedTime = filemtime($filePath) * 1000;

        // Insert into MongoDB
        $collection->insertOne([
            'username' => get_current_user(),
            'file_name' => $file,
            'file_path' => $filePath,
            'modified_time' => new MongoDB\BSON\UTCDateTime($modifiedTime),
            'session_id' => $sessionId,
            'timestamp' => new MongoDB\BSON\UTCDateTime()
        ]);
    }
}

echo "✅ File activity logged successfully.\n";
?>
