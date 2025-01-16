<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || !isset($_SESSION['type']) || ($_SESSION['type'] !== '1')) {
    header('Location: ../index.php');
    exit();
}