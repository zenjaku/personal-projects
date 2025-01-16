<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/tomaraoStyles.css">
    <title>Tomarao Examinations</title>
</head>

<?php
$mobile = isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/mobile/i', $_SERVER['HTTP_USER_AGENT']);
?>

<?php if ($mobile): ?>
    <frameset rows="20%,20%,*,10%" frameborder="1">
        <frame src="components(frames)/tomaraoHeader.php">
            <frame src="components(frames)/tomaraoLoginSignUp.php" noresize>
                <frame src="components(frames)/tomaraoIndex.php" noresize name="mid_column">
                    <frame src="components(frames)/tomaraoFooter.php" noresize scrolling="no">
    </frameset>
<?php else: ?>
    <frameset rows="20%,*,10%" frameborder="1">
        <frameset cols="60%,*">
            <frame src="components(frames)/tomaraoHeader.php" noresize scrolling="no">
                <frame src="components(frames)/tomaraoLoginSignUp.php" noresize scrolling="no">
        </frameset>
        <frame src="components(frames)/tomaraoIndex.php" noresize name="mid_column">
            <frame src="components(frames)/tomaraoFooter.php" noresize scrolling="no">
    </frameset>
<?php endif; ?>

</html>