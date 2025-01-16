<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/tomaraoStyles.css">
		<title></title>
	</head>
<body id="floresNav">

<ul class="floresButton">

<?php

include_once('php/tomaraoConnection.php');
session_start();

// Correct $_SESSION instead of $SESSION
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    // admins
    if ($_SESSION['type'] == 1) {
        echo "<li><a href='tomaraoAddProducts.php' target='mid_column'><button type='button' class='tomaraoLogin'> Add Product </button></a></li>";
        echo "<li><a href='tomaraoAdminProduct.php' target='mid_column'><button type='button' class='tomaraoLogin'> Product Table </button></a></li>";
        echo "<li><a href='tomaraoClients.php' target='mid_column'><button type='button' class='tomaraoLogin'> Clients </button></a></li>";
    }
    echo "<li><a href='php/tomaraoLogout.php' target='mid_column'><button type='button' class='tomaraoClear'> Logout </button></a></li>";

} else {
    echo "<li><a href='tomaraoRegistration.php' target='mid_column'><button type='button' class='tomaraoRegister'> Registration </button></a></li>
          <li><a href='tomaraoLogin.php' target='mid_column'><button type='button' class='tomaraoLogin'>  Log In </button></a></li>";
}

?>

</ul>

</body>
</html>
