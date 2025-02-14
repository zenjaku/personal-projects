@echo off
REM Run with administrative privileges
NET FILE 1>NUL 2>NUL || (
    echo Requesting administrative privileges...
    powershell -Command "Start-Process cmd -ArgumentList '/c %~s0' -Verb RunAs"
    exit /b
)

REM Log the logout event with timestamp
echo [%DATE% %TIME%] Logout event detected >> C:\logs\logout_log.txt
php "C:\security_scripts\log_events.php" logout

REM Log final app usage
call "C:\security_scripts\log_apps.cmd"

REM Log final browser history
call "C:\security_scripts\log_web.cmd"

REM Log final file activity
call "C:\security_scripts\log_files.cmd"

REM Optionally, log web history to MongoDB
php "C:\security_scripts\log_web_to_mongo.php"

REM Ensure script has enough time to execute
powershell -command "Start-Sleep -Seconds 10"

REM Log completion
echo [%DATE% %TIME%] Logout script completed successfully >> C:\logs\logout_log.txt
