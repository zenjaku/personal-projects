Now, let's set up the Windows Task Scheduler to run these scripts automatically.

A. Configure the Login Task
Open Task Scheduler:

Press Win + R, type taskschd.msc, and press Enter.
Create a New Task:

In Task Scheduler, click Create Task.
Under the General tab, set a name like Login Event.
In the Security Options, choose Run whether user is logged on or not.
Configure the Trigger:

Click the Triggers tab.
Click New, and select At logon.
Configure the Action:

Under the Actions tab, click New, and select Start a Program.
Browse to the log_login.cmd script in C:\secure_scripts\.
Save the Task:

Click OK to save the task.
B. Configure the Logout Task
Follow similar steps to create a task for logging out:
Name it Logout Event.
Set the Trigger to At logoff.
Under Actions, point to the log_logout.cmd script in C:\secure_scripts\.



Protect the Scripts:

Set directory permissions to prevent standard users from reading or modifying the scripts.
powershell: icacls "C:\secure_scripts" /inheritance:r /grant administrators:F
powershell: icacls "C:\secure_scripts\.env" /inheritance:r /grant administrators:F


<!-- block_sites -->
Run Manually or via Task Scheduler
To unblock manually, open PowerShell as Administrator and run:

powershell.exe -ExecutionPolicy Bypass -File "C:\security_scripts\unblock_sites.ps1"
If you want to schedule it (e.g., after work hours), follow the same Task Scheduler steps but use:

C:\security_scripts\unblock_sites.ps1
instead of block_sites.ps1
