<!DOCTYPE html>
<html>
<head>
    <title>LOGIN</title>
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
            width: 250px;
            height: 70px;
           } 

.tomaraoSubmit {
            background-color:yellowgreen;
            border-color:green;
            color: white  ;
            font-size: 20px;
            width: 150px;
            height: 40px;
        }     
}
</style>
<?php

session_start();

$tomarao = mysqli_connect("localhost","root","","renzocalculator");

if ($tomarao === false)
{
die("ERROR:Could not connect." . mysqli_connect_error());
}

if(isset($_POST["SUBMIT"]))
{
    $tomaraoUsername = $_POST["tomarao_Username"];
    $tomaraoPassword = $_POST["tomarao_Password"];
    $login = mysqli_query($tomarao, "SELECT * FROM registration WHERE tomarao_Username = '$tomaraoUsername'");
    $row = mysqli_fetch_assoc($login);

    if (mysqli_num_rows($login) > 0 ) {
        if($tomaraoPassword == $row["tomarao_Password"]){
            $_SESSION['login'] = true;
            $_SESSION['id'] = $row["id"];
            header("Location: tomaraoMainPage.php");
            exit();
        } else {
            echo "<script> alert ('Incorrect Password'); </script>";
        }

    } else {
        echo "<script> alert ('Username is not Registered'); </script>";
        }

        // Close the database connection
    mysqli_close($tomarao);
    }
    
?>

       <form action="" method="POST" autocomplete="off">

    <h1>LOGIN FORM</h1>

        <H2>
    <table>
    <tr>
    <td><label for="tomaraoUsername">Username</label></td>
    <td><input type="text" id="tomaraoUsername" name ="tomarao_Username" required value=""><br></td>
    </tr>

    <tr>
    <td><label for="tomaraoPassword">Password</label></td>
    <td><input type="password" id="tomaraoPassword" name ="tomarao_Password" required value=""><br></td>
    </tr>

</table>
 <br>
<button type="submit" class="tomaraoSubmit" name="SUBMIT"> Login </button>
<button type="reset" class="tomaraoSubmit"> Clear </button>
 <br>
 <br>
 <br>

<a href="tomaraoRegistration.php"> <button type="button" class="tomaraoView">Registration</button></a>
</form>
</body>
</html>