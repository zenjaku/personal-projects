<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/tomaraoStyles.css">
    <title>Tomarao Examinations</title>
</head>

<body>
    <div class="main-container">
        <div class="container">
            <h1>Login</h1>
            <form id="loginForm" action="php/tomaraoLogin.php" method="POST" autocomplete="off">
                <div class="inputGroup">
                    <label for="tomarao_Username">Username</label>
                    <input type="text" name="tomarao_Username" id="tomarao_Username" required>
                </div>
                <div class="inputGroup">
                    <label for="tomarao_Password">Password</label>
                    <input type="password" name="tomarao_Password" id="tomarao_Password" required>
                </div>
                <button type="submit" class="tomaraoSignup" name="LOGIN">Login</button>
                <button type="reset" class="tomaraoClear">Cancel</button>
            </form>
        </div>
    </div>
</body>

</html>