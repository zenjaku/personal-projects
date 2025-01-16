<!DOCTYPE html>
<html>
<head>
    <title>REGISTRATION</title>
<style>

body {background: goldenrod;} 
 h1 {color: blue;} 
 h1 {font-family: Tahoma;} 
 h1 {text-align: left;} 
 h1 {font-size: 40px;} 
 h2 {color: green;} 
 h2 {font-family: Verdana;} 
 h2 {text-align: left;} 
 h2 {font-size: 25px;} 
 p {color: whitesmoke;} 
 p {font-family: Helvetica;} 
 p {text-align: left;} 
 p {font-size: 25px;} 
 input {
    width: 150px;
    height: 40px;}

.tomaraoView {
            background-color:red;
            border-color:green;
            color: white  ;
            font-size: 20px;
            width: 150px;
            height: 40px;
           } 

.tomaraoSubmit {
            background-color:yellowgreen;
            border-color:green;
            color: white  ;
            font-size: 20px;
            width: 150px;
            height: 40px;
        }

</style>
</head>
<?php

// create connection
// $connection name = mysqli_connect ("servername/host", "username","password", "DB name")

$tomarao = mysqli_connect("localhost","root","","renzocalculator");


// Check connection

if ($tomarao === false)
{
die("ERROR:Could not connect." . mysqli_connect_error());
}

// Taking  values from the form data(input textbox)

if(isset($_POST["SUBMIT"]))
{
    $tomaraoNum1 = $_REQUEST['tomarao_Num1'];
    $tomaraoNum2 = $_REQUEST['tomarao_Num2'];

    $tomaraoProd = $tomaraoNum1 * $tomaraoNum2;

//  insert the data into  table
//sql name = "INSERT INTO tableName VALUES ('$textBox','$textBox')";

    $renzo = "INSERT INTO multiplication 
              VALUES ('$tomaraoNum1', '$tomaraoNum2', '$tomaraoProd')";

// Check if the query is successful
    if (mysqli_query($tomarao, $renzo)) {
        echo "<table>";
        echo "<tr><td class='tomaraoSubmit'>The product of the two numbers is: $tomaraoProd </td></tr>";
        echo "<tr><td colspan='2'>
                <form action='' method='GET'>
                    <button type='submit' class='tomaraoView'>Clear</button>
                </form>
              </td></tr>";
        echo "</table";

    } else {
        echo "<h2> ERROR: Sorry, $renzo </h2>" . mysqli_error($tomarao);
    }

    // Close connection
    mysqli_close($tomarao);
} else {
?>

<body>

    <form action="" method="POST" autocomplete="off">
        <h1>MULTIPLICATION</h1>
    <table>
        <tr><td><input type="number" id="tomaraoNum1" name="tomarao_Num1" placeholder="Number 1" required></td>
        <td><input type="number" id="tomaraoNum2" name="tomarao_Num2" placeholder="Number 2" required></td>
        <td><button type="submit" class="tomaraoSubmit" name="SUBMIT">Total</button></td>
        <td><button type="reset" class="tomaraoView">Clear</button></td></tr>
    </table>
    </form>

<?php
}
?>
</body>
</html>