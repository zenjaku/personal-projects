<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="css/tomaraoStyles.css">
    <title>LOGIN</title>

<body id="login">
<form action="php/tomaraoLogin.php" method="POST" autocomplete="off">

    <h1>LOGIN FORM</h1>
    <table>

        <tr>
        <td class="floresColumn"><label for="tomaraoUsername">Username</label></td>
        <td class="floresColumn"><input type="text" id="tomaraoUsername" name ="tomarao_Username" required><br></td>
        </tr>

        <tr>
        <td class="floresColumn"><label for="tomaraoPassword">Password</label></td>
        <td class="floresColumn"><input type="password" id="tomaraoPassword" name ="tomarao_Password" required><br></td>
        </tr>

    </table>

 <br>

    <button type="submit" class="tomaraoLogin" name="SUBMIT"> Login </button>
    <button type="reset" class="tomaraoClear"> Clear </button>

 <br>
 <br>

<a href="tomaraoRegistration.php"> <button type="button" class="tomaraoRegister">Registration</button></a>
</form>
</body>
</html>