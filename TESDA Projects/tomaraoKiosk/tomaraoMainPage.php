<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tomarao Kiosk</title>
</head>
<frameset rows="20%,*,10%" frameborder="1">
    <frameset cols="70%,*">
        <frame src="tomaraoHeader.php" noresize scrolling="no">
        <frame src="tomaraoLoginSignup.php" noresize scrolling="no">
    </frameset>

    <?php
    session_start();
    if ($_SESSION['tomarao_type'] === 1) {
        echo '<frame src="tomaraoAdminProduct.php" name="mid_column" noresize scrolling="auto">';

    } else {
       echo  '<frame src="tomaraoProduct.php" name="mid_column" noresize scrolling="auto">';
    }

    ?>
    <frame src="tomaraoFooter.php" noresize scrolling="no">
</frameset>
<body>
</body>
</html>
