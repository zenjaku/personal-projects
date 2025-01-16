<?php

include_once('tomaraoConnection.php');

if(isset($_POST["SUBMIT"]))
{
    $productname = $_REQUEST['name'];
    $unit = $_REQUEST['unit'];
    $priceperunit = $_REQUEST['price_per_unit'];
    $image = $_REQUEST['image_url'];

//  insert the data into  table
//sql name = "INSERT INTO tableName VALUES ('$textBox','$textBox')";
$renzo = "INSERT INTO products (name, unit, price_per_unit, image_url)
            VALUES ('$productname','$unit', '$priceperunit', '$image')";

// Check if the query is successful

if (mysqli_query($tomarao, $renzo)) {
   echo "<script> alert ('Product $productname, added successfully!');
                        window.location.href = '../tomaraoAdminProduct.php'; </script>";
}
else {

    echo "<script> alert ('Failed to add Product'); </script>";
}

}

// Close connection

mysqli_close($tomarao);

?>