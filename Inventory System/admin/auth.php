<?php

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    $_SESSION['status'] = 'failed';
    $_SESSION['failed'] = 'You are not authorized to access this page.';
    echo "<script> window.location = 'index.php?page=register'; </script>";
    exit();
}
?>