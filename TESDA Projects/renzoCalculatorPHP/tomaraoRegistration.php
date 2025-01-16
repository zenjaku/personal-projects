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
    $tomaraoFname = $_REQUEST['tomarao_Fname'];
    $tomaraoLname = $_REQUEST['tomarao_Lname'];
    $tomaraoEmail = $_REQUEST['tomarao_Email'];
    $tomaraoUsername = $_REQUEST['tomarao_Username'];
    $tomaraoPassword = $_REQUEST['tomarao_Password'];
    $tomaraoConfirmedPassword = $_REQUEST['tomarao_ConfirmedPassword'];
    $tomaraoPnumber = $_REQUEST['tomarao_Phone'];
    $tomaraoSaddress = $_REQUEST['tomarao_Street'];
    $tomaraoSbarangay = $_REQUEST['tomarao_Barangay'];
    $tomaraoCity = $_REQUEST['tomarao_City'];
    $tomaraoAprovince = $_REQUEST['tomarao_Province'];
    $tomaraoPzipcode = $_REQUEST['tomarao_Code'];
    $tomaraoCountry = $_REQUEST['tomarao_Country'];
    $tomaraoCname = $_REQUEST['tomarao_Company'];
    $tomaraoAcount = $_REQUEST['tomarao_Count'];

//  insert the data into  table
//sql name = "INSERT INTO tableName VALUES ('$textBox','$textBox')";
$renzo = "INSERT INTO registration (tomarao_Fname, tomarao_Lname, tomarao_Email, tomarao_Username, tomarao_Password, tomarao_ConfirmedPassword, tomarao_Phone, tomarao_Street, tomarao_Barangay, tomarao_City, tomarao_Province, tomarao_Code, tomarao_Country, tomarao_Company, tomarao_Count)
            VALUES ('$tomaraoFname','$tomaraoLname', '$tomaraoEmail', '$tomaraoUsername', '$tomaraoPassword','$tomaraoConfirmedPassword', '$tomaraoPnumber','$tomaraoSaddress', '$tomaraoSbarangay', '$tomaraoCity', '$tomaraoAprovince','$tomaraoPzipcode', '$tomaraoCountry', '$tomaraoCname','$tomaraoAcount')";

// Check if the query is successful

if (mysqli_query($tomarao, $renzo)) {
   echo "<script> alert ('Registration Successfully, $tomaraoFname $tomaraoLname'); </script>";
}
else {

    echo "ERROR: Sorry, $renzo. " . mysqli_error($tomarao);
}

}

// Close connection

mysqli_close($tomarao);

?>

<body>


    <form action="" method="POST" autocomplete="off">
    <h1>REGISTRATION FORM</h1>
    
     <h2>   
<table>
    <tr>
    <td><label for="tomaraoFname">Full Name</label></td>
    <td><input type="text"  id="tomaraoFname" name="tomarao_Fname" required value=""><br></td>
    <td><input type="text" id="tomaraoLname" name="tomarao_Lname"><br></td>
    </tr>


     <tr>
    <td><label for="tomaraoBlankFname1"></label></td>
    <td><label for="tomaraoFname1">First Name</label></td>
    <td><label for="tomaraoMname1"> Last Name</label></td>
    </tr>

    <tr>
    <td><label for="tomaraoEmail">E-Mail</label></td>
    <td><input type="email" id="tomaraoEmail" name="tomarao_Email"><br></td>
    </tr>


    <tr>
    <td><label for="tomaraoUserName">Username</label></td>
    <td><input type="text" id="tomaraoUsername" name="tomarao_Username"><br></td>
    </tr>

    <tr>
    <td><label for="tomaraoPassword">Password</label></td>
    <td><input type="password" id="tomaraoPassword" name="tomarao_Password"><br></td>
    </tr>

     <tr>
    <td><label for="tomaraoConfirmedPassword">Confirmed Password</label></td>
    <td><input type="password" id="tomaraoConfirmedPassword" name="tomarao_ConfirmedPassword"><br></td>
    </tr>
   
    <tr>
    <td><label for="tomaraoPnumber">Phone Number</label></td>
    <td><input type="number" id="tomaraoPnumber" name="tomarao_Phone"><br></td>    
    </tr>


    <tr>
    <td><label for="tomaraoAddress">Address</label></td>
    <td><input type="text" id="tomaraoSaddress" name="tomarao_Street"><br></td>
    <td><input type="text" id="tomaraoSbarangay" name="tomarao_Barangay"><br></td>
    </tr>
    
     <tr>
    <td><label for="tomaraoBlankSAddress"></label></td>
    <td><label for="tomaraoSaddress1">Stress Add</label></td>
    <td><label for="tomaraoSaddress1">Barangay</label></td>
    </tr>

    <tr>
    <td><label for="tomaraoBlankSAddress1"></label></td>
    <td><input type="text" id="tomaraoCity" name="tomarao_City"><br></td>
    <td><input type="text" id="tomaraoAprovince" name="tomarao_Province"><br></td>
    </tr>
    
    <tr>
    <td><label for="tomaraoBlankSAddress1"></label></td>
    <td><label for="tomaraoCity1">City</label></td>
    <td><label for="tomaraoSprovince1">State/Province</label></td>
    </tr>

     <tr>
    <td><label for="tomaraoBlankSAddress2"></label></td>
    <td><input type="number" id="tomaraoPzipcode" name="tomarao_Code"><br></td>
    <td><input type="text" id="tomaraoCountry" name="tomarao_Country"><br></td>
    </tr>
    
    <tr>
    <td><label for="tomaraoBlankSAddress2"></label></td>
    <td><label for="tomaraoPzipcode">Zip Code</label></td>
    <td><label for="tomaraoCountry">Country</label></td>
    </tr>

    <tr>
    <td><label for="tomaraoCname">Company Name</label></td>
    <td><input type="text" id="tomaraoCname" name="tomarao_Company"><br></td>
    </tr>

    <tr>
    <td><label for="tomaraoAcount">Attendee count</label></td>
    <td><input type="number" id="tomaraoAcount" name="tomarao_Count"><br></td>
    </tr>

<br>
</table>  
    </h2>
    <button type="submit" class="tomaraoSubmit" name="SUBMIT"> SUBMIT </button>
</form>


<br>
<a href="tomaraoLogin.php">
<button type="button" class="tomaraoView"> LOGIN</button>
</a>
</body>
</html>


