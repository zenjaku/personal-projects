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
$collection = $client->company_logs->app_usage;

// Get session ID
$sessionIdFile = "C:\\logs\\session_id.txt";
$sessionId = file_exists($sessionIdFile) ? trim(file_get_contents($sessionIdFile)) : "unknown_session";

// Fetch active processes using PowerShell
$processes = shell_exec('powershell "Get-Process | Select-Object ProcessName, StartTime | ConvertTo-Json"');
$processes = $processes ? json_decode($processes, true) : [];

foreach ($processes as $process) {
    if (!isset($process['ProcessName'], $process['StartTime'])) continue;

    $collection->insertOne([
        'username' => get_current_user(),
        'process_name' => $process['ProcessName'],
        'start_time' => new MongoDB\BSON\UTCDateTime(strtotime($process['StartTime']) * 1000),
        'session_id' => $sessionId,
        'timestamp' => new MongoDB\BSON\UTCDateTime()
    ]);
}

echo "✅ Application usage logged successfully.\n";
?>
