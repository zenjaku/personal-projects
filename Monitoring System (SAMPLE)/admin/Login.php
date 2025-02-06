<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <div class="container py-5 d-flex flex-column align-items-center" id="register">
        <div class="shadow-lg p-4 rounded-lg d-flex flex-column align-items-center">
            <h1 class="mb-5">LOGIN</h1>
            <form action="server/user-method.php" method="post" autocomplete="off" id="registerForm">
                <div class="row d-flex flex-column gap-4">
                    <div class="col-md-6 col-sm-12 form-floating">
                        <input type="text" id="username" name="username" class="form-control" required>
                        <label for="username">Username</label>
                    </div>
                    <div class="col-md-6 col-sm-12 form-floating">
                        <input type="password" id="password" name="password" class="form-control" required>
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary" name="login">Submit</button>
                    <button type="reset" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>