<div class="container py-4 d-flex flex-column align-items-center" id="register">
    <div class="shadow-lg bg-white p-4 rounded-lg d-flex flex-column align-items-center">
        <h1 class="mb-5">REGISTER</h1>
        <form action="/register-admin" method="post" autocomplete="off" id="registerForm">
            <div class="row d-flex my-3">
                <div class="col-6 form-floating">
                    <input type="text" id="fname" name="fname" class="form-control" required>
                    <label for="fname">First Name</label>
                </div>
                <div class="col-6 form-floating">
                    <input type="text" id="lname" name="lname" class="form-control" required>
                    <label for="lname">Last Name</label>
                </div>
            </div>
            <div class="row d-flex flex-column my-3 gap-3">
                <div class="col form-floating">
                    <input type="number" id="contact" name="contact" class="form-control w-100" required
                        pattern="\d{11}" maxlength="11" oninput="validateContact(this)">
                    <label for="contact">Contact Number</label>
                </div>
                <div class="col form-floating">
                    <input type="email" id="email" name="email" class="form-control" required>
                    <label for="email">Email Address</label>
                </div>
                <div class="col form-floating">
                    <input type="text" id="username" name="username" class="form-control" required>
                    <label for="username">Username</label>
                </div>
                <div class="col form-floating">
                    <input type="password" id="password" name="password" class="form-control" required>
                    <label for="password">Password</label>
                </div>
                <div class="col form-floating">
                    <input type="password" id="cpassword" name="cpassword" class="form-control" required>
                    <label for="cpassword">Confirm Password</label>
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn btn-dark" name="register">Submit</button>
                <button type="button" class="btn btn-danger" onclick="parent.location.href=''">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function validateZip(input) {
        if (input.value.length > 5) {
            input.value = input.value.slice(0, 5);
        }
    }
    function validateContact(input) {
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11);
        }
    }

    function validateAge(input) {
        if (input.value < script 0) {
            input.value = '';
        }
    }
</script>