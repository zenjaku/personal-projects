<?php
require 'vendor/autoload.php'; // Include MongoDB driver (if you are using Composer)

// Function to load .env file variables (MongoDB URI)
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

loadEnv(__DIR__ . '/.env');  // Load the .env file

// MongoDB connection details from .env file
$mongoUri = $_ENV['MONGO_URI'];
$client = new MongoDB\Client($mongoUri);

// Select the MongoDB database and collection
$collection = $client->company_logs->login_logs;

// Get the system username and event type (login/logout)
$username = get_current_user();
$eventType = $argv[1];  // Pass "login" or "logout" as an argument
$timestamp = new MongoDB\BSON\UTCDateTime();

// Insert the event data into the database
$insertResult = $collection->insertOne([
    'username' => $username,
    'event_type' => $eventType,
    'timestamp' => $timestamp
]);

if ($insertResult->getInsertedCount() === 1) {
    echo "Log saved successfully\n";
} else {
    echo "Error saving log\n";
}
?>
