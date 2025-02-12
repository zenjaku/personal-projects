@echo off
REM Log the logout event
php "C:\security_scripts\log_events.php" logout

REM Log final app usage
call "C:\security_scripts\log_apps.cmd"

REM Log final browser history
call "C:\security_scripts\log_web.cmd"

REM Log final file activity
call "C:\security_scripts\log_files.cmd"

REM Optionally, log web history to MongoDB
php "C:\security_scripts\log_web_to_mongo.php"