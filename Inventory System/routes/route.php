<?php
// Route definitions
$routes = [
    '~^/$~' => 'pages/home.php',
    '~^/login$~' => 'admin/login.php',
    '~^/admin-register$~' => 'admin/admin-register.php',

    // Protected pages (require login)
    '~^/inventory$~' => 'pages/inventory.php',
    '~^/add$~' => 'pages/add_assets.php',
    '~^/specs$~' => 'pages/specs.php',
    '~^/history$~' => 'pages/history.php',
    '~^/allocate$~' => 'pages/allocate.php',
    '~^/employee$~' => 'pages/employee.php',
    '~^/view$~' => 'pages/view.php',
    '~^/logout$~' => 'server/logout.php',
    '~^/register$~' => 'pages/register.php',
    '~^/parts$~' => 'pages/parts.php',
    '~^/build$~' => 'pages/build-computer.php',
    '~^/remove-parts$~' => 'server/remove-parts.php',
    '~^/add-to$~' => 'pages/add-to.php',

    // Form submissions (should be protected)
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
    '/inventory',
    '/add',
    '/specs',
    '/history',
    '/allocate',
    '/employee',
    '/view',
    '/add-assets',
    '/register-employee',
    '/allocation-assets',
    '/logout',
    '/register',
    '/parts',
    '/build',
    '/add-to',
    '/build-pc',
    '/transfer-assets',
    '/return-assets',
    '/remove-parts'
];

foreach ($routes as $pattern => $file) {
    if (preg_match($pattern, $request)) {
        $matched = true;

        // **Redirect logged-in users away from the login page**
        if ($request === '/login' && isset($_SESSION['login']) && $_SESSION['login'] === true) {
            echo "<script> window.location = '/'; </script>";
            exit();
        }

        // **Restrict access to protected pages**
        if (in_array($request, $protected_routes) && (!isset($_SESSION['login']) || $_SESSION['login'] !== true)) {
            $_SESSION['status'] = 'failed';
            $_SESSION['failed'] = 'Please login to continue.';
            echo "<script> window.location = '/login'; </script>";
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