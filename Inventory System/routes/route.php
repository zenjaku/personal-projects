<?php
// session_start(); // Start session to track logged-in users

// Route definitions
$routes = [
    '~^/login$~' => 'admin/login.php',
    '~^/admin-register$~' => 'admin/admin-register.php',
    '~^/inventory-custody$~' => 'pages/inventory-custody.php',
    '~^/register-admin$~' => 'form/admin-register-form.php',
    '~^/esignature$~' => 'form/signature-form.php',
    '~^/employee-id$~' => 'pages/get-employee-id.php',

    '~^/$~' => 'pages/home.php',
    '~^/inventory$~' => 'pages/inventory.php',
    '~^/add$~' => 'pages/add_assets.php',
    '~^/specs$~' => 'pages/specs.php',
    '~^/history$~' => 'pages/history.php',
    '~^/allocate$~' => 'pages/allocate.php',
    '~^/employee$~' => 'pages/employee.php',
    '~^/logout$~' => 'server/logout.php',
    '~^/register$~' => 'pages/register.php',
    '~^/parts$~' => 'pages/parts.php',
    '~^/build$~' => 'pages/build-computer.php',
    '~^/remove-parts$~' => 'server/remove-parts.php',
    '~^/add-to$~' => 'pages/add-to.php',
    '~^/users$~' => 'admin/users.php',
    '~^/approve$~' => 'server/approve.php',
    '~^/delete$~' => 'server/delete.php',
    '~^/add-assets$~' => 'form/inventory-form.php',
    '~^/register-employee$~' => 'form/register-form.php',
    '~^/allocation-assets$~' => 'form/allocation-form.php',
    '~^/build-pc$~' => 'form/build-form.php',
    '~^/add-asset$~' => 'form/add-to-form.php',
    '~^/transfer-assets$~' => 'form/transfer-form.php',
    '~^/return-assets$~' => 'form/return-form.php',
];

$request = strtok($_SERVER['REQUEST_URI'], '?'); // Remove query string
$matched = false;

$protected_routes = [
    '/',
    '/users', // Now protected
    '/inventory',
    '/add',
    '/specs',
    '/history',
    '/allocate',
    '/employee',
    '/logout',
    '/register',
    '/parts',
    '/build',
    '/remove-parts',
    '/add-to',
    '/approve',
    '/delete',
    '/add-assets',
    '/register-employee',
    '/allocation-assets',
    '/build-pc',
    '/add-asset',
    '/transfer-assets',
    '/return-assets',
];

foreach ($routes as $pattern => $file) {
    if (preg_match($pattern, $request)) {
        $matched = true;

        // Redirect logged-in users away from the login page
        if ($request === '/login' && isset($_SESSION['login']) && $_SESSION['login'] === true) {
            echo "<script> window.location = '/'; </script>";
            exit();
        }

        // Restrict access to protected pages
        if (in_array($request, $protected_routes) && (!isset($_SESSION['login']) || $_SESSION['login'] !== true)) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Please login to continue.';
            echo "<script> window.location = '/login'; </script>";
            exit();
        }

        // Restrict access to /users page based on session type
        if ($request === '/users' && (!isset($_SESSION['type']) || $_SESSION['type'] !== 1)) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'You do not have permission to access this page.';
            echo "<script> window.location = '/'; </script>";
            exit();
        }


        require $file;
        break;
    }
}

// If no match is found, return 404
if (!$matched) {
    http_response_code(404);
    echo '404 Page not found';
}
?>