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
            <h1>Registration</h1>
            <form id="registerForm" action="php/tomaraoInsert.php" method="POST" autocomplete="off">
                <div class="inputGroup">
                    <label for="tomarao_Fname">First Name</label>
                    <input type="text" name="tomarao_Fname" id="tomarao_Fname" required>
                </div>
                <div class="inputGroup">
                    <label for="tomarao_Lname">Last Name</label>
                    <input type="text" name="tomarao_Lname" id="tomarao_Lname" required>
                </div>
                <div class="inputGroup">
                    <label for="tomarao_Email">Email Address</label>
                    <input type="email" name="tomarao_Email" id="tomarao_Email" required>
                </div>
                <div class="inputGroup">
                    <label for="tomarao_Username">Username</label>
                    <input type="text" name="tomarao_Username" id="tomarao_Username" required>
                </div>
                <div class="inputGroup">
                    <label for="tomarao_Password">Password</label>
                    <input type="password" name="tomarao_Password" id="tomarao_Password" required>
                </div>
                <div class="inputGroup">
                    <label for="tomarao_cPassword">Confirm Password</label>
                    <input type="password" name="tomarao_cPassword" id="tomarao_cPassword" required>
                </div>
                <button type="submit" class="tomaraoSignup" name="SUBMIT">Submit</button>
                <button type="reset" class="tomaraoClear">Cancel</button>
            </form>
        </div>
    </div>
</body>

</html>