<?php

include_once("server/connection.php");
session_start();
function isActivePage($page)
{
    // Default to "home" if no page parameter is set
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 'home';
    return $currentPage === $page ? 'navbar-active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenrose</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom sticky-top">
        <div class="container-fluid">
            <a class="nav-link" aria-current="page" href="index.php?page=home">
                <img src="assets/logo.png" alt="" class="img-fluid nav-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll gap-4">
                    <li class="nav-item">
                        <a class="lead text-uppercase nav-link <?= isActivePage('home') ?>" aria-current="page"
                            href="index.php?page=home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="lead text-uppercase nav-link <?= isActivePage('collections') ?>" aria-current="page"
                            href="index.php?page=collections">Collections</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isActivePage('cart') ?>" aria-current="page" href="index.php?page=cart">
                            <i class="fa-solid fa-cart-shopping text-dark"></i>
                            <div class="cartNumber bg-warning text-center ms-3 mt-2" id="cartItem">0</div>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user text-dark"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if (isset($_SESSION['login']) && $_SESSION['login']): ?>
                                <?php if ($_SESSION['type'] != 1): ?>
                                    <li><a class="dropdown-item btn btn-warning" role="button" href="#">Profile</a></li>
                                <?php endif; ?>
                                <?php if ($_SESSION['type'] == 1): ?>
                                    <li><a class="dropdown-item btn btn-warning" role="button" href="#">Profile</a></li>
                                    <li><a class="dropdown-item btn btn-warning" role="button" href="index.php?page=admin">Admin
                                            Panel</a></li>
                                <?php endif; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item btn btn-warning" role="button" href="server/logout.php">Sign
                                        Out</a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item btn btn-warning" role="button" href="#" data-bs-toggle="modal"
                                        data-bs-target="#loginModal">Login</a></li>
                                <li><a class="dropdown-item btn btn-warning" role="button" href="#" data-bs-toggle="modal"
                                        data-bs-target="#registerModal">Register</a></li>
                            <?php endif; ?>

                        </ul>
                    </li>
                    <form class="d-flex" role="search">
                        <div class="search-border">
                            <input class="me-2 searchbar" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </ul>
            </div>
        </div>
    </nav>


    <section id="login">
        <div class="modal fade justify-content-center align-content-center" id="loginModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <img src="assets/logo.png" alt="" class="img-fluid nav-logo">
                    </div>
                    <form id="loginForm" class="form" action="server/login.php" method="POST" autocomplete="off">
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="lUsername" name="username"
                                    placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" id="lPassword" name="password"
                                    placeholder="Password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning" name="LOGIN">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section id="register">
        <div class="modal fade justify-content-center align-content-center" id="registerModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <img src="assets/logo.png" alt="" class="img-fluid nav-logo">
                    </div>
                    <form id="registerForm" class="form" action="server/register.php" method="POST" autocomplete="off">
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="email" id="email"
                                    placeholder="Email Address" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="Password" required>
                                <div id="passwordStrengthAlert" class="alert bg-danger mt-2 d-none text-white"
                                    role="alert">
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                    placeholder="Confirm Password" required>
                                <div id="passwordMatchAlert" class="alert bg-danger mt-2 d-none text-white"
                                    role="alert"></div>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" name="address" id="address"
                                    placeholder="Complete Mailing Address" required>
                            </div>
                            <div class="mb-3">
                                <!-- <input type="number" class="form-control" name="contact" id="contact"
                                    placeholder="Contact Number" oninput="enforceMaxLength(this)" required> -->
                                <input type="text" class="form-control" name="contact" id="contact"
                                    placeholder="Contact Number" maxlength="11" required
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" />

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning" name="REGISTER">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("password");
        const confirmPasswordInput = document.getElementById("confirmPassword");
        const passwordStrengthAlert = document.getElementById("passwordStrengthAlert");
        const passwordMatchAlert = document.getElementById("passwordMatchAlert");

        // Function to hide alerts after a timeout
        function hideAlert(alertElement) {
            setTimeout(() => {
                alertElement.classList.add("d-none"); // Hide alert
            }, 5000); // Hides alert after 1.5 seconds (adjust as needed)
        }

        // Function to check password strength
        function checkPasswordStrength(password) {
            const minLength = 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            if (password.length < minLength || !hasUpperCase || !hasLowerCase || !hasNumber || !hasSpecialChar) {
                passwordStrengthAlert.textContent = "Password is not strong enough. Use at least 8 characters with uppercase, lowercase, number, and special character.";
                passwordStrengthAlert.classList.remove("d-none"); // Show alert
                passwordStrengthAlert.classList.replace("bg-success", "bg-danger"); // Set alert to danger
                hideAlert(passwordStrengthAlert);
                return false;
            } else {
                passwordStrengthAlert.textContent = "Password strength is sufficient.";
                passwordStrengthAlert.classList.remove("d-none"); // Show alert
                passwordStrengthAlert.classList.replace("bg-danger", "bg-success"); // Set alert to success
                hideAlert(passwordStrengthAlert);
                return true;
            }
        }

        // Function to check if passwords match
        function checkPasswordMatch() {
            if (passwordInput.value && confirmPasswordInput.value && passwordInput.value !== confirmPasswordInput.value) {
                passwordMatchAlert.textContent = "Passwords do not match.";
                passwordMatchAlert.classList.remove("d-none"); // Show alert
                passwordMatchAlert.classList.replace("bg-success", "bg-danger"); // Set alert to danger
                hideAlert(passwordMatchAlert);
            } else if (passwordInput.value && confirmPasswordInput.value && passwordInput.value === confirmPasswordInput.value) {
                passwordMatchAlert.textContent = "Passwords match.";
                passwordMatchAlert.classList.remove("d-none"); // Show alert
                passwordMatchAlert.classList.replace("bg-danger", "bg-success"); // Set alert to success
                hideAlert(passwordMatchAlert);
            } else {
                passwordMatchAlert.classList.add("d-none"); // Hide alert
            }
        }

        // Event listeners for real-time validation
        passwordInput.addEventListener("input", function () {
            checkPasswordStrength(passwordInput.value);
            checkPasswordMatch();
        });
        confirmPasswordInput.addEventListener("input", checkPasswordMatch);

    });

    document.addEventListener('DOMContentLoaded', () => {
        const cartItem = document.getElementById('cartItem');
        let cartCount = parseInt(cartItem.textContent, 10) || 0;

        // Add to Cart button logic
        document.querySelectorAll('.addToCart').forEach(button => {
            button.addEventListener('click', () => {
                cartCount++;
                updateCartDisplay();
            });
        });

        // Quantity input change logic
        document.querySelectorAll('.itemQuantity').forEach(input => {
            input.addEventListener('input', (event) => {
                const quantity = parseInt(event.target.value, 10);
                if (quantity > 0) {
                    cartCount = quantity;
                    updateCartDisplay();
                } else {
                    event.target.value = 1;
                }
            });
        });

        function updateCartDisplay() {
            cartItem.textContent = cartCount;
        }
    });


</script>

</html>