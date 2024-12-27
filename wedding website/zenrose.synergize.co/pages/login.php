<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <section id="auth" class="container p-3">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 col-sm-12 card shadow p-2 border border-dark text-center gap-4" id="login">
                <h1>Login</h1>
                <div class="card-body">
                    <form action="../server/server-api.php" method="post" autocomplete="off" id="authForm" class="d-flex flex-column gap-3">
                        <div class="form-floating">
                            <input type="text" name="username" id="username" placeholder="Username" class="form-control" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
                            <label for="password">Password</label>
                        </div>
                        <button type="submit" class="btn btn-success w-100" name="login">Login</button>
                    </form>
                </div>
                <p>Don't have an account? Click <a href="#" id="registerBtn">here</a> to sign up.</p>
            </div>
            <div class="col-md-6 col-sm-12 card shadow p-2 border border-dark text-center gap-4" id="register" >
                <h1>Register</h1>
                <form action="../server/server-api.php" method="post" autocomplete="off" id="authForm" class="d-flex flex-column gap-3 py-4">
                    <div class="form-floating">
                        <input type="text" name="fname" id="fname" placeholder="First Name" class="form-control" required>
                        <label for="fname">First Name</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" name="lname" id="lname" placeholder="Last Name" class="form-control" required>
                        <label for="lname">Last Name</label>
                    </div>
                    <div class="form-floating">
                        <input type="email" name="email" id="email" placeholder="Email Address" class="form-control" required>
                        <label for="email">Email Address</label>
                    </div>
                    <div class="form-floating">
                        <input type="text" name="username" id="username-register" placeholder="Username" class="form-control" required>
                        <label for="username-register">Username</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="password" id="password-register" placeholder="Password" class="form-control" required>
                        <label for="password-register">Password</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" required>
                        <label for="confirmPassword">Confirm Password</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100" name="register">Register</button>
                </form>
                <div class="question">
                    <p>Have an account? Click <a href="#" id="loginBtn">here</a> to sign in.</p>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>