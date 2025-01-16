<?php

include_once('tomaraoConnection.php');

if(isset($_POST["SUBMIT"]))
{
    $tomaraoFname = $_REQUEST['tomarao_Fname'];
    $tomaraoLname = $_REQUEST['tomarao_Lname'];
    $tomaraoEmail = $_REQUEST['tomarao_Email'];
    $tomaraoUsername = $_REQUEST['tomarao_Username'];
    $tomaraoPassword = $_REQUEST['tomarao_Password'];
    $tomaraoConfirmedPassword = $_REQUEST['tomarao_ConfirmedPassword'];
    $tomaraoType = 0;
    $tomaraoStatus = 0;

//  insert the data into  table
//sql name = "INSERT INTO tableName VALUES ('$textBox','$textBox')";
$renzo = "INSERT INTO tomaraoregistration (tomarao_Fname, tomarao_Lname, tomarao_Email, tomarao_Username, tomarao_Password, tomarao_ConfirmedPassword, tomarao_type, tomarao_status)
            VALUES ('$tomaraoFname','$tomaraoLname', '$tomaraoEmail', '$tomaraoUsername', '$tomaraoPassword','$tomaraoConfirmedPassword', $tomaraoType, $tomaraoStatus)";

// Check if the query is successful

if (mysqli_query($tomarao, $renzo)) {
   echo "<script> alert ('Registration Successfully, $tomaraoFname $tomaraoLname');
                        window.location.href = '../tomaraoLogin.php'; </script>";
}
else {

    echo "ERROR: Sorry, $renzo. " . mysqli_error($tomarao);
}

}

// Close connection

mysqli_close($tomarao);

?>