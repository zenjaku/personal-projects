
<?php

session_start();

include_once('tomaraoConnection.php');

if(isset($_POST["SUBMIT"]))
{
    $tomaraoUsername = $_POST["tomarao_Username"];
    $tomaraoPassword = $_POST["tomarao_Password"];
    $login = mysqli_query($tomarao, "SELECT * FROM tomaraoregistration WHERE tomarao_Username = '$tomaraoUsername'");
    $row = mysqli_fetch_assoc($login);

    if (mysqli_num_rows($login) > 0 ) {
        if($tomaraoPassword == $row["tomarao_Password"]){

            //admin login
            if ($row["tomarao_status"] == 1 ) {
                if ($row["tomarao_type"] == 1) {
                    $_SESSION['login'] = true;
                    $_SESSION['type'] = $row["tomarao_type"];
                      echo "<script> parent.location.href='../tomaraoMainPage.php';
                                    parent.frames['mid_column'].location.href = '../tomaraoAdminProduct.php';
                                     </script>";
                  } else {
                    $_SESSION['login'] = true;
                    $_SESSION['type'] = $row["tomarao_type"];
                      echo "<script> parent.location.href='../tomaraoMainPage.php'; </script>";
                  }

              } else {
                echo "<script> alert ('Your account is currently inactive.');
                    parent.location.href='../tomaraoMainPage.php'; </script>";
              }

        } else {
            echo "<script> alert ('Incorrect Password'); 
                    parent.location.href='../tomaraoMainPage.php'; </script>";
        }

    } else {
        echo "<script> alert ('Username is not Registered');
                    parent.location.href='../tomaraoMainPage.php'; </script>";
        }

        // Close the database connection
    mysqli_close($tomarao);
    }
    
?>