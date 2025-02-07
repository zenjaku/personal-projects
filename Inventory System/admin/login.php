<div class="container py-5 d-flex flex-column align-items-center" id="register">
    <div class="shadow-lg bg-white p-4 rounded-lg d-flex flex-column align-items-center">
        <h1 class="mb-5">LOGIN</h1>
        <form action="server/login.php" method="post" autocomplete="off" id="loginForm">
            <div class="row d-flex flex-column gap-4">
                <div class="col-md-6 col-sm-12 form-floating">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                        required>
                    <label for="username">Username</label>
                </div>
                <div class="col-md-6 col-sm-12 form-floating">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password"
                        required>
                    <label for="password">Password</label>
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn btn-dark" name="login">Submit</button>
                <button type="reset" class="btn btn-danger">Cancel</button>
            </div>
        </form>
    </div>
</div>