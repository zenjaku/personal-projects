<?php
require 'vendor/autoload.php';

function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        throw new Exception("Environment file not found.");
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0)
            continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// Load environment variables
loadEnv(__DIR__ . '/.env');

// Ensure the log directory exists
$logDir = 'C:\\logs';
if (!is_dir($logDir)) {
    if (!mkdir($logDir, 0755, true)) {
        die("❌ Failed to create log directory: $logDir");
    }
}

// MongoDB connection
$mongoUri = $_ENV['MONGO_URI'];
$client = new MongoDB\Client($mongoUri);
$collection = $client->company_logs->web_history;

// Retrieve session ID
$sessionIdFile = "C:\\logs\\session_id.txt";
$sessionId = file_exists($sessionIdFile) ? trim(file_get_contents($sessionIdFile)) : "unknown_session";

// Get all user profiles
$userProfiles = glob("C:\\Users\\*", GLOB_ONLYDIR);

// Supported browser history paths
$browserHistoryPaths = [
    'chrome' => "\\AppData\\Local\\Google\\Chrome\\User Data\\Default\\History",
    'edge' => "\\AppData\\Local\\Microsoft\\Edge\\User Data\\Default\\History",
    'firefox' => "\\AppData\\Roaming\\Mozilla\\Firefox\\Profiles"
];

// Process history for each user
foreach ($userProfiles as $userProfile) {
    $username = basename($userProfile);

    foreach ($browserHistoryPaths as $browser => $historyPath) {
        if ($browser === 'firefox') {
            $firefoxProfiles = glob("$userProfile$historyPath\\*.default-release", GLOB_ONLYDIR);
            if (empty($firefoxProfiles))
                continue;
            $historyPath = $firefoxProfiles[0] . "\\places.sqlite";
        } else {
            $historyPath = $userProfile . $historyPath;
        }

        if (!file_exists($historyPath))
            continue;

        // Copy database to avoid locking issue
        $tempCopy = "C:\\logs\\History_Copy_{$username}_{$browser}.db";
        if (!copy($historyPath, $tempCopy)) {
            echo "❌ Failed to copy history file for $username ($browser). Check permissions.\n";
            continue;
        }

        try {
            $db = new SQLite3($tempCopy, SQLITE3_OPEN_READONLY);

            if ($browser === 'firefox') {
                // Check the schema and update the query accordingly
                $query = 'SELECT url, title, last_visit_date FROM moz_places ORDER BY last_visit_date DESC LIMIT 10';
            } else {
                $query = 'SELECT url, title, last_visit_time FROM urls ORDER BY last_visit_time DESC LIMIT 10';
            }

            $results = $db->query($query);

            if ($results === false) {
                throw new Exception("Query failed: " . $db->lastErrorMsg());
            }

            while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
                if ($browser === 'firefox') {
                    // Adjust the timestamp calculation based on the correct column
                    $timestamp = $row['last_visit_date'] / 1000000;
                } else {
                    $timestamp = ($row['last_visit_time'] / 1000000) - 11644473600;
                }

                $collection->insertOne([
                    'username' => $username,
                    'browser' => ucfirst($browser),
                    'url' => $row['url'],
                    'title' => $row['title'],
                    'visit_time' => new MongoDB\BSON\UTCDateTime($timestamp * 1000),
                    'session_id' => $sessionId,
                    'timestamp' => new MongoDB\BSON\UTCDateTime()
                ]);
            }

            $db->close();
            unlink($tempCopy); // Remove temporary copy
            echo "✅ Web history logged successfully for $username on $browser.\n";
        } catch (Exception $e) {
            echo "❌ Error accessing $browser history for $username: " . $e->getMessage() . "\n";
            if (file_exists($tempCopy)) {
                unlink($tempCopy);
            }
        }
    }
}
?>