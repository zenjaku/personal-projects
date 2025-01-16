<!DOCTYPE html>
<html>
<head>
    <title>LOGIN</title>
    
<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = [];

// Unset the session
session_unset();

// Destroy the session
session_destroy();

// Redirect to the main page
header("Location: tomaraoLogin.php");
exit();
?>
</head>
<body>
</body>
</html>