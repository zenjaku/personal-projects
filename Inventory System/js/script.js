document.addEventListener('DOMContentLoaded', () => {
    navigationMenu();
    resetBtn();
    count();
    initSpinner();
    checkScreenWidth();
    editBtn();
    getActivePage();
    checkPassword();
    parseURL();
})

window.addEventListener('resize', checkScreenWidth);

function checkScreenWidth() {
    // Only redirect if the width is less than 769px and not already on the access page
    if (window.innerWidth < 769 && !window.location.pathname.includes('access.html')) {
        // Redirect to access.html
        window.location.href = "access.html"; // Absolute URL or relative path if appropriate
    }
}

function parseURL() {
    const input = document.getElementById("id");
    const submit = document.getElementById("submitBtn");

    if(!input || !submit) return;

    input.addEventListener("input", () => {
        submit.disabled = input.value.trim() === "";
    })

    submit.addEventListener("click", () => {
        const url = '/inventory-custody?employee_id=' + encodeURIComponent(input.value);
        window.location = url;
        console.log("URL: ", url);
    })
}

function checkPassword() {
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("cpassword");
    const registerBtn = document.getElementById("registerBtn");
    const toastMessage = document.getElementById("toastMessage");
    const toastElement = document.getElementById("toastAlert");


    if(!password || !confirmPassword || !registerBtn || !toastMessage || !toastMessage) return;

    // Bootstrap Toast initialization
    const toast = new bootstrap.Toast(toastElement);

    // Set confirm password field as readonly initially
    confirmPassword.readOnly = true;
    registerBtn.disabled = true;

    // Strong password regex
    function isStrongPassword(pwd) {
        const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        return strongRegex.test(pwd);
    }

    // Show toast alert
    function showToast(message, type) {
        toastMessage.innerHTML = message;
        toastElement.classList.remove("bg-danger", "bg-warning", "bg-success"); // Reset previous colors

        if (type === "error") {
            toastElement.classList.add("bg-danger"); // Red for errors
        } else if (type === "warning") {
            toastElement.classList.add("bg-warning"); // Yellow for warnings
        } else if (type === "success") {
            toastElement.classList.add("bg-success"); // Green for success
        }

        toast.show();
    }

    // Password input event
    password.addEventListener("input", function () {
        if (!isStrongPassword(password.value)) {
            confirmPassword.readOnly = true;
            registerBtn.disabled = true;
            showToast("Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.", "error");
        } else {
            confirmPassword.readOnly = false;
            showToast("Password meets the criteria!", "success");
        }
    });

    // Confirm password input event
    confirmPassword.addEventListener("input", function () {
        if (password.value !== confirmPassword.value) {
            registerBtn.disabled = true;
            showToast("Passwords do not match!", "warning");
        } else {
            registerBtn.disabled = false;
            showToast("Passwords match!", "success");
        }
    });
}


function getActivePage() {
    const link = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-link');

    sidebarLinks.forEach((sidebarLink) => {
        if (sidebarLink.getAttribute('href') === link) {
            sidebarLink.classList.add('active');
        } else {
            sidebarLink.classList.remove('active'); // Remove active class from others
        }
    });
}

function editBtn() {
    const editBtn = document.getElementById('editBtn');
    const selectField = document.getElementById('allocation-status');
    if (!editBtn || !selectField) return;

    console.log(editBtn, selectField);

    // Initially disable the select field
    selectField.disabled = true;

    // Add click event listener for the edit button
    editBtn.addEventListener('click', function () {
        // Toggle the disabled state of the select field
        selectField.disabled = !selectField.disabled; // If it's disabled, enable it; if it's enabled, disable it

        // Toggle the text content of the edit button
        if (selectField.disabled) {
            editBtn.textContent = 'Edit';
            editBtn.classList.remove('bg-danger'); // If the select field is disabled, show 'Edit'
        } else {
            editBtn.textContent = 'Cancel';
            editBtn.classList.add('bg-danger'); // If the select field is enabled, show 'Cancel'
        }
    });
}

function initSpinner() {
    const spinner = document.querySelector('#global-spinner');
    if (!spinner) return;

    const toggleSpinner = (show) => spinner.classList.toggle('show', show);

    // Hide spinner when the DOM is fully loaded
    window.addEventListener('load', () => toggleSpinner(false));

    window.addEventListener('load', () => {
        toggleSpinner(false);
        spinner.classList.remove('d-flex')
    })

    // Show spinner on form submission
    document.querySelectorAll('form').forEach((form) => form.addEventListener('submit', () => toggleSpinner(true)));

    // Show spinner when the page is about to unload
    window.addEventListener('beforeunload', () => toggleSpinner(true));
}

function navigationMenu() {

    const toggler = document.querySelector(".toggler-btn");
    if (!toggler) return;
    toggler.addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("collapsed");
    });

}

function resetBtn() {
    const resetBtn = document.getElementById('resetBtn');
    if (!resetBtn) return;

    resetBtn.onclick = () => {
        parent.location.href = "index.php";
    }
}

function count() {
    const inventoryBtn = document.getElementById('inventoryBtn');
    const inventory = document.getElementById('inventory');
    const overlay = document.getElementById('overlay');
    const pages = document.querySelectorAll('.page-item a');

    if (!inventoryBtn || !inventory || !overlay || !pages) return;

    // Show the modal if the query parameter `showModal` is set
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('showModal')) {
        overlay.classList.remove('hidden');
        inventory.classList.remove('hidden');
    }

    inventoryBtn.onclick = () => {
        overlay.classList.remove('hidden');
        inventory.classList.remove('hidden');
        updateURL(true); // Add `showModal` to URL
    };

    overlay.onclick = () => {
        overlay.classList.add('hidden');
        inventory.classList.add('hidden');
        updateURL(false); // Remove `showModal` from URL
    };

    // Add the `showModal` parameter to pagination links
    pages.forEach(page => {
        page.onclick = (event) => {
            event.preventDefault(); // Prevent the default link behavior
            const href = new URL(page.href);
            href.searchParams.set('showModal', '1');
            window.location.href = href.toString();
        };
    });

    // Helper function to update the URL
    function updateURL(showModal) {
        const currentUrl = new URL(window.location.href);
        if (showModal) {
            currentUrl.searchParams.set('showModal', '1');
        } else {
            currentUrl.searchParams.delete('showModal');
        }
        window.history.replaceState({}, '', currentUrl.toString());
    }
}

