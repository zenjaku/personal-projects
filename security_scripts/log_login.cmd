@echo off
php "C:\security_scripts\log_events.php" login

:loop
call "C:\security_scripts\log_apps.cmd"
call "C:\security_scripts\log_web.cmd"
call "C:\security_scripts\log_files.cmd"
powershell -command "Start-Sleep -Seconds 60"
goto loop
