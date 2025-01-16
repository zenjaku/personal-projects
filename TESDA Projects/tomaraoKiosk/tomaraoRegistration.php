<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/tomaraoStyles.css">
    <title>REGISTRATION</title>

</head>

<body id="registration">


<form action="php/tomaraoInsert.php" method="POST" autocomplete="off">
    <h1>REGISTRATION FORM</h1>  
        <table>
            <tr>
            <td><label for="tomaraoFname">Full Name</label></td>
            <td><input type="text"  id="tomaraoFname" name="tomarao_Fname" required><br></td>
            <td><input type="text" id="tomaraoLname" name="tomarao_Lname" required style="width: 100%;"><br></td>
            </tr>


            <tr>
            <td><label for="tomaraoBlankFname1"></label></td>
            <td><label for="tomaraoFname1">First Name</label></td>
            <td><label for="tomaraoMname1"> Last Name</label></td>
            </tr>

            <tr>
            <td><label for="tomaraoEmail">E-Mail</label></td>
            <td colspan="2"><input type="email" id="tomaraoEmail" name="tomarao_Email" style="width: 100%;"><br></td>
            </tr>


            <tr>
            <td><label for="tomaraoUserName">Username</label></td>
            <td colspan="2"><input type="text" id="tomaraoUsername" name="tomarao_Username" maxlength="12" style="width: 100%;"><br></td>
            </tr>

            <tr>
            <td><label for="tomaraoPassword">Password</label></td>
            <td colspan="2"><input type="password" id="tomaraoPassword" name="tomarao_Password" maxlength="10" style="width: 100%;"><br></td>
            </tr>

             <tr>
            <td><label for="tomaraoConfirmedPassword">Confirmed Password</label></td>
            <td colspan="2"><input type="password" id="tomaraoConfirmedPassword" name="tomarao_ConfirmedPassword" maxlength="10" style="width: 100%;"><br></td>
            </tr>
            
            <tr>
                <td></td>
                <td> <button type="submit" class="tomaraoRegister" name="SUBMIT"> SUBMIT </button> </td>
                <td> 
                    <a href="tomaraoLogin.php">
                        <button type="button" class="tomaraoLogin"> LOGIN</button>
                    </a>
                </td>
            </tr>
        </table>

        <table>
        </table>

    
       
</form>
</body>
</html>


