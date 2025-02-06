<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle_btn" type="button">
                    <img src="assets/p_1.png" alt="DILG Logo" class="img-fluid dilg_logo">
                </button>
                <div class="sidebar_logo">
                    <a href="#">DILG</a>
                </div>
            </div>
            <ul class="sidebar_nav d-flex flex-column gap-3">
                <li class="sidebar_item">
                    <a href="#" class="sidebar_link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth" aria-expanded="false" aria-controls="auth" title="Auth">
                        <i class="fa-solid fa-user-lock"></i>
                        <span>Auth</span>
                    </a>
                    <ul id="auth" class="sidebar_dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar_item">
                            <a href="#" class="sidebar_link">Login</a>
                        </li>
                        <!-- <li class="sidebar_item">
                            <a href="#" class="sidebar_link">Register</a>
                        </li> -->
                    </ul>
                </li>
                <li class="sidebar_item">
                    <a href="#" class="sidebar_link" title="Profile">
                        <i class="fa-regular fa-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <!-- <li class="sidebar_item">
                    <a href="#" class="sidebar_link" title="Report">
                        <i class="fa-solid fa-chart-simple"></i>
                        <span>Report</span>
                    </a>
                </li> -->
                <li class="sidebar_item">
                    <a href="#" class="sidebar_link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#multi" aria-expanded="false" aria-controls="multi" title="Data">
                        <i class="fa-solid fa-database"></i>
                        <span>Data</span>
                    </a>
                    <ul id="multi" class="sidebar_dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar_item">
                            <a href="index.php?page=register" class="sidebar_link">Register</a>
                        </li>
                        <li class="sidebar_item">
                            <a href="#" class="sidebar_link">Report</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar_item">
                    <a href="#" class="sidebar_link" title="Notification">
                        <i class="fa-solid fa-bell"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <li class="sidebar_item">
                    <a href="#" class="sidebar_link" title="Settings">
                        <i class="fa-solid fa-gears"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar_footer">
                <a href="#" class="sidebar_link" title="Logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main p-3">
            <div class="text-center">
                <h1>
                    DILG Monitoring System
                </h1>
            </div>
        </div>
    </div>
</body>

</html>