<?php
session_start();
session_destroy();
session_unset();
echo "<script> parent.location.href = '../index.php'; </script>";
exit();
?>
