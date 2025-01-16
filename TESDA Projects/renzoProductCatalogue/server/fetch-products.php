<?php
include_once('connections.php');

$fetchProducts = "SELECT * FROM product";
$result = mysqli_query($connection, $fetchProducts);

