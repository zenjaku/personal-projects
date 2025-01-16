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

.guirreView {
            background-color:red;
            border-color:green;
            color: white  ;
            font-size: 20px;
            width: 250px;
            height: 70px;
           } 

.guirreSubmit {
            background-color:yellowgreen;
            border-color:green;
            color: white  ;
            font-size: 20px;
            width: 250px;
            height: 70px;
        }

      
}

</style>
        <?php

        // create connection
        // $connection name = mysqli_connect ("servername/host", "username","password", "DB name")
     
     $bryan = mysqli_connect("localhost","root","","calculator");

     
        // Check connection

    if ($bryan === false)
    {
        die("ERROR:Could not connect." . mysqli_connect_error());
    }



        // Taking  values from the form data(input textbox)
   

    if(isset($_POST["SUBMIT"]))
        $guirreFname = $_REQUEST['guirre_Fname'];
        $guirreLname = $_REQUEST['guirre_Lname'];
        $guirreEmail = $_REQUEST['guirre_Email'];
        $guirreUsername = $_REQUEST['guirre_Username'];
        $guirrePassword = $_REQUEST['guirre_Password'];
        $guirreConfirmedPassword = $_REQUEST['guirre_ConfirmedPassword'];
        //  insert the data into  table
        //sql name = "INSERT INTO tableName VALUES ('$textBox','$textBox')";
        $suarez = "INSERT INTO registration VALUES ('$guirreFname','$guirreLname', '$guirreEmail', '$guirreUsername', '$guirrePassword','$guirreConfirmedPassword')";
       
        // Check if the query is successful

        if (mysqli_query($bryan,$suarez))

        {

            echo "<h1>Registration Successfully.</h1>";

            echo nl2br("<h2> $guirreFname \n $guirreLname </h2>");
        } else {

            echo "ERROR:Sorry $suarez. " . mysqli_error($bryan);
        }
       
        // Close connection

        mysqli_close($bryan);
       
        ?>

        <a href="guirreLogin.php" class="guirreView"> LOGIN </a>
</body>
</html>