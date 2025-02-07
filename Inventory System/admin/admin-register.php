<div class="container py-4 d-flex flex-column align-items-center" id="register">
    <div class="shadow-lg bg-white p-4 rounded-lg d-flex flex-column align-items-center">
        <h1 class="mb-5">REGISTER</h1>
        <form action="/register-admin" method="post" autocomplete="off" id="registerForm">
            <div class="row d-flex my-3">
                <div class="col-6 form-floating">
                    <input type="text" id="fname" name="fname" placeholder="First Name" class="form-control" required>
                    <label for="fname">First Name</label>
                </div>
                <div class="col-6 form-floating">
                    <input type="text" id="lname" name="lname" placeholder="Last Name" class="form-control" required>
                    <label for="lname">Last Name</label>
                </div>
            </div>
            <div class="row d-flex flex-column my-3 gap-3">
                <div class="col form-floating">
                    <input type="number" id="contact" name="contact" placeholder="Contact Number"
                        class="form-control w-100" required pattern="\d{11}" maxlength="11"
                        oninput="validateContact(this)">
                    <label for="contact">Contact Number</label>
                </div>
                <div class="col form-floating">
                    <input type="email" id="email" name="email" placeholder="Email Address" class="form-control"
                        required>
                    <label for="email">Email Address</label>
                </div>
                <div class="col form-floating">
                    <input type="text" id="username" name="username" placeholder="Username" class="form-control"
                        required>
                    <label for="username">Username</label>
                </div>
                <div class="col form-floating">
                    <input type="password" id="password" name="password" placeholder="Password" class="form-control"
                        required>
                    <label for="password">Password</label>
                </div>
                <div class="col form-floating">
                    <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password"
                        class="form-control" required>
                    <label for="cpassword">Confirm Password</label>
                </div>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn btn-dark" name="adminRegister" id="registerBtn">Submit</button>
                <button type="button" class="btn btn-danger" onclick="parent.location.href=''">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Notification -->
<div class="position-fixed top-0 end-0 px-3" style="z-index: 1050">
    <div id="toastAlert" class="toast align-items-center text-white bg-danger border-0" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                <!-- Message will be inserted dynamically -->
            </div>
            <!-- <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button> -->
        </div>
    </div>
</div>


<script>
    function validateContact(input) {
        if (input.value.length > 11) {
            input.value = input.value.slice(0, 11);
        }
    }
    // Function to show toast notifications
    function showToast(message, status) {
        // Define colors based on status
        const bgColor = status === 'success' ? 'warning' : 'danger';
        const textColor = bgColor === 'danger' ? 'text-white' : '';

        // Create the toast element
        const toast = document.createElement('div');
        toast.className = `toast show bg-${bgColor} ${textColor}`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
        <div class="toast-body justify-content-between d-flex">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
        </div>
    `;

        // Create the toast container if it doesn't exist
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        // Append the toast to the container
        toastContainer.appendChild(toast);

        // Automatically remove the toast after 3 seconds
        setTimeout(() => toast.remove(), 3000);
    }
    $(document).ready(function () {
        var isUsernameValid = false; // Flag to track if username is valid
        const registerBtn = document.getElementById('registerBtn');

        registerBtn.disabled = true; // Correct way to disable the button initially

        // Function to check if username exists
        function checkUsernameExists(username) {
            $.ajax({
                method: 'POST',
                url: 'server/jquery/check_username.php', // Ensure this file handles the check
                data: { username: username },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.exists) {
                        showToast('Username already exists. Please choose a different username.', 'error');
                        isUsernameValid = false;
                    } else {
                        isUsernameValid = true;
                    }
                    registerBtn.disabled = !isUsernameValid; // Enable or disable the button based on validation
                },
                error: function () {
                    showToast('Error checking username. Please try again.', 'error');
                    isUsernameValid = false;
                    registerBtn.disabled = true;
                }
            });
        }

        // Event listener for username input field
        $('#username').on('input', function () {
            var username = $(this).val().trim();
            if (username.length > 0) {
                checkUsernameExists(username);
            } else {
                isUsernameValid = false;
                registerBtn.disabled = true; // Ensure the button is disabled if input is empty
            }
        });
    });


</script>