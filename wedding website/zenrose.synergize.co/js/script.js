document.addEventListener('DOMContentLoaded', () => {
  // hamburgerMenu();
  getPage();
  gallery();
  // imageScale();
  initSpinner();
  authPage();
  passwordMatch();
  // loginCheck();
  googleMap();
  // cleanUrl();
  editGoogleMap();
  editDetails();
});

function initSpinner() {
  const spinner = document.querySelector('#global-spinner');
  if (!spinner) return;

  const toggleSpinner = (show) => spinner.classList.toggle('show', show);

  // Hide spinner when the DOM is fully loaded
  window.addEventListener('load', () => toggleSpinner(false));

  // Show spinner on form submission
  document.querySelectorAll('form').forEach((form) => form.addEventListener('submit', () => toggleSpinner(true)));

  // Show spinner when the page is about to unload
  window.addEventListener('beforeunload', () => toggleSpinner(true));
}

// function hamburgerMenu() {
//   const navLinks = document.querySelector('.nav');
//   const hamburgerEl = document.querySelector('.hamburger');

//   if (!navLinks || !hamburgerEl) return; // Exit if elements are not found

//   // Toggle menu when the hamburger is clicked
//   hamburgerEl.addEventListener('click', (e) => {
//     navLinks.classList.toggle('nav-open');
//     hamburgerEl.classList.toggle('hamburger-open');
//     e.stopPropagation(); // Prevent click from bubbling to the document
//   });

//   // Close the menu when a link inside the menu is clicked
//   navLinks.addEventListener('click', () => {
//     navLinks.classList.remove('nav-open');
//     hamburgerEl.classList.remove('hamburger-open');
//   });

//   // Close the menu when clicking outside
//   document.addEventListener('click', (e) => {
//     if (!navLinks.contains(e.target) && !hamburgerEl.contains(e.target)) {
//       navLinks.classList.remove('nav-open');
//       hamburgerEl.classList.remove('hamburger-open');
//     }
//   });
// }

function getPage() {
  const activePage = window.location.href; // Get the full URL
  const navBtns = document.querySelectorAll('.nav-item .nav-link'); // Get all nav links

  // console.log(activePage);

  if (!navBtns.length) return; // Exit if no nav links are found

  navBtns.forEach((navBtn) => {
    // Check if the current page is the home page
    if (window.location.pathname === '/' && navBtn.getAttribute('href') === 'index.php?page=home') {
      navBtn.classList.add('active'); // Highlight the "Home" button
    } else if (activePage.includes(navBtn.getAttribute('href'))) {
      navBtn.classList.add('active'); // Highlight other buttons based on the URL
    } else {
      navBtn.classList.remove('active'); // Remove active class from non-matching buttons
    }
  });

  // Add event listener to update the active class on click
  navBtns.forEach((navBtn) => {
    navBtn.addEventListener('click', (e) => {
      // Remove 'navbar-active' class from all buttons
      navBtns.forEach((btn) => btn.classList.remove('active'));

      // Add 'active' class to the clicked button
      e.target.classList.add('active');
    });
  });
}

function gallery() {
  const slider = document.querySelector('.gallery-container');
  const nextBtn = document.getElementById('next');
  const prevBtn = document.getElementById('prev');

  if (!slider || !nextBtn || !prevBtn) return; // Exit if any required element is missing

  // Function to move the slider to the next image
  function moveNext() {
    slider.append(slider.querySelector('img:first-child'));
  }

  // Function to move the slider to the previous image
  function movePrev() {
    slider.prepend(slider.querySelector('img:last-child'));
  }

  // Set up auto-slide with an interval (e.g., every 3 seconds)
  setInterval(moveNext, 3500);

  // Button click handlers for manual control
  nextBtn.onclick = moveNext;
  prevBtn.onclick = movePrev;
}

// function imageScale() {
//   const img = document.querySelectorAll('.card-group img');
//   const overlayImg = document.querySelector('.scale-overlay');

//   if (!img.length || !overlayImg) return; // Exit if no images or overlay element is found

//   img.forEach((image) => {
//     image.addEventListener('click', (e) => {
//       // Show the overlay
//       overlayImg.style.display = 'flex';

//       // Add the image to the overlay
//       const scaledImage = e.target.cloneNode(true); // Clone the clicked image
//       scaledImage.classList.add('image-scale');
//       overlayImg.innerHTML = ''; // Clear any previous content in the overlay
//       overlayImg.appendChild(scaledImage);
//     });
//   });

//   // Close the overlay when clicking on it
//   overlayImg.addEventListener('click', () => {
//     overlayImg.style.display = 'none';
//   });
// }

function authPage() {
  const login = document.getElementById('login');
  const register = document.getElementById('register');
  const loginBtn = document.getElementById('loginBtn');
  const registerBtn = document.getElementById('registerBtn');

  if (!login || !register || !loginBtn || !registerBtn) return;

  // console.log(login, register, loginBtn, registerBtn)

  register.style.display = 'none';

  if (registerBtn) {
    registerBtn.onclick = () => {
      login.style.display = 'none';
      register.style.display = 'block';
    };
  }

  if (loginBtn) {
    loginBtn.onclick = () => {
      login.style.display = 'block';
      register.style.display = 'none';
    };
  }
}

function passwordMatch() {
  const passwordInput = document.getElementById('password-register');
  const confirmPasswordInput = document.getElementById('confirmPassword');
  const usernameInput = document.getElementById('username-register');
  const registerBtn = document.querySelector('button[name="register"]');

  if (!registerBtn || !passwordInput || !confirmPasswordInput || !usernameInput) return;

  registerBtn.disabled = true;

  const passwordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{8,}$/;

  const showToast = (message, type) => {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();

    // Clear existing toasts
    toastContainer.innerHTML = '';

    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0`;
    toast.role = 'alert';
    toast.ariaLive = 'assertive';
    toast.ariaAtomic = 'true';
    toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">
          ${message}
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    `;
    toastContainer.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
  };

  const createToastContainer = () => {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'toast-container position-fixed top-0 end-0 p-3 py-5';
    document.body.appendChild(container);
    return container;
  };

  const validateUsername = () => {
    if (usernameInput.value.length === 0) {
      return false;
    }
    const isUsernameValid = usernameInput.value.length >= 6;
    if (!isUsernameValid) {
      showToast('Username must be at least 6 characters long.', 'danger');
      registerBtn.disabled = true;
    }
    return isUsernameValid;
  };

  const validatePassword = () => {
    if (passwordInput.value.length === 0) {
      return false;
    }
    const isPasswordValid = passwordRegex.test(passwordInput.value);
    if (!isPasswordValid) {
      showToast(
        'Password must be at least 8 characters long and include at least one uppercase letter, one number, and one special character.',
        'danger'
      );
      registerBtn.disabled = true;
    }
    return isPasswordValid;
  };

  const validateConfirmPassword = () => {
    if (confirmPasswordInput.value.length === 0) {
      return false;
    }
    const passwordsMatch = passwordInput.value === confirmPasswordInput.value;
    if (!passwordsMatch) {
      showToast('Passwords do not match.', 'danger');
      registerBtn.disabled = true;
    } else {
      showToast('Passwords matched.', 'success');
      registerBtn.disabled = true;
    }
    return passwordsMatch;
  };

  const enableRegisterButton = () => {
    if (validateUsername() && validatePassword() && validateConfirmPassword()) {
      registerBtn.disabled = false;
    }
  };

  usernameInput.addEventListener('input', () => {
    validateUsername();
    enableRegisterButton();
  });

  passwordInput.addEventListener('input', () => {
    validatePassword();
    enableRegisterButton();
  });

  confirmPasswordInput.addEventListener('input', () => {
    validateConfirmPassword();
    enableRegisterButton();
  });
}

// function loginCheck() {
//   const username = document.querySelector('input[id="username"]');
//   const password = document.querySelector('input[id="password"]');
//   const loginBtn = document.querySelector('button[name="login"]');

//   if (!username || !password || !loginBtn) return;

//   const showAlert = (message, type, id) => {
//     let alert = document.getElementById(id);
//     if (!alert) {
//       alert = document.createElement('div');
//       alert.id = id;
//       alert.className = `alert ${type}`;
//       alert.innerHTML = `<strong>${message}</strong><button type="button" class="btn-close">X</button>`;
//       document.body.appendChild(alert);

//       document.querySelectorAll('.btn-close').forEach((btn) => {
//         btn.addEventListener('click', () => alert.remove());
//       });

//       setTimeout(() => alert.remove(), 1500);
//     }
//   };

//   loginBtn.addEventListener('click', (event) => {
//     event.preventDefault(); // Prevent the form from submitting
//     let isValid = true;

//     if (username.value.trim() === '') {
//       showAlert('Username is required.', 'bg-danger', 'usernameAlert');
//       isValid = false;
//     } else {
//       const existingAlert = document.getElementById('usernameAlert');
//       if (existingAlert) existingAlert.remove();
//     }

//     if (password.value.trim() === '') {
//       showAlert('Password is required.', 'bg-danger', 'passwordAlert');
//       isValid = false;
//     } else {
//       const existingAlert = document.getElementById('passwordAlert');
//       if (existingAlert) existingAlert.remove();
//     }

//     if (isValid) {
//       // Proceed with login logic (e.g., form submission or API call)
//       // console.log('Login successful');
//     }
//   });
// }

function googleMap() {
  const mapLinkWedElement = document.getElementById('map-link-wed');
  const mapLinkRepElement = document.getElementById('map-link-rep');
  const googleBtn = document.getElementById('googleMap');

  if (!mapLinkWedElement || !mapLinkRepElement || !googleBtn) return;

  // Update the validation function to check for iframe links
  const isValidMapLink = (link) => {
    const iframeRegex = /<iframe.*?src="(.*?)"/; // Regex to check for iframe src
    return iframeRegex.test(link);
  };

  const showToast = (message, type) => {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    toastContainer.innerHTML = '';
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0`;
    toast.role = 'alert';
    toast.ariaLive = 'assertive';
    toast.ariaAtomic = 'true';
    toast.innerHTML = `
      <div class="d-flex">
        <div class="toast-body">
          ${message}
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    `;
    toastContainer.appendChild(toast);
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
  };

  const createToastContainer = () => {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'toast-container position-fixed top-0 end-0 p-3 py-5';
    document.body.appendChild(container);
    return container;
  };

  const validateLinks = () => {
    const mapLinkWed = mapLinkWedElement.value;
    const mapLinkRep = mapLinkRepElement.value;

    // Only show toast if the links are invalid
    if (!mapLinkWed || !mapLinkRep || !isValidMapLink(mapLinkWed) || !isValidMapLink(mapLinkRep)) {
      showToast('Please enter a valid Google Map iframe link.', 'danger');
      googleBtn.disabled = true;
    } else {
      googleBtn.disabled = false; // Enable button if links are valid
    }
  };

  // Add event listeners to update button state in real-time
  mapLinkWedElement.addEventListener('input', validateLinks);
  mapLinkRepElement.addEventListener('input', validateLinks);
}

// window.addEventListener('load', () => {
//   const currentPath = window.location.href;

//   // Only clean URLs with 'index.php?page='
//   if (currentPath.includes('index.php?page=')) {
//     const urlParams = new URLSearchParams(window.location.search);
//     const page = urlParams.get('page');

//     // Ensure 'page' parameter exists
//     if (page) {
//       const newUrl = `${window.location.origin}/${page}`;

//       // Update the URL without reloading the page
//       if (currentPath !== newUrl) {
//         history.replaceState(null, '', newUrl);
//         console.log('URL cleaned to:', newUrl);
//       }
//     }
//   } else {
//     console.log('URL is already clean:', currentPath);
//   }
// });

function editGoogleMap() {
  const updateBtn = document.getElementById('updateEdit');
  const submitBtn = document.getElementById('updateSubmit');
  const cancelBtn = document.getElementById('cancelBtn');
  const inputFields = document.querySelectorAll('#editGoogleMap input');
  const pTag = document.querySelectorAll('.displayed-fields');
  const textArea = document.querySelectorAll('#editGoogleMap textarea');

  // Initialize button visibility
  const toggleButtonVisibility = (isEditing) => {
    submitBtn.style.display = isEditing ? 'block' : 'none';
    cancelBtn.style.display = isEditing ? 'block' : 'none';
    updateBtn.style.display = isEditing ? 'none' : 'block';
  };

  toggleButtonVisibility(false); // Start in view mode

  // Disable each input and textarea field
  const setFieldsState = (isDisabled) => {
    inputFields.forEach((field) => (field.disabled = isDisabled));
    textArea.forEach((field) => (field.style.display = isDisabled ? 'none' : 'block'));
    pTag.forEach((field) => (field.style.display = isDisabled ? 'block' : 'none'));
  };

  setFieldsState(true); // Disable fields initially

  updateBtn.addEventListener('click', () => {
    toggleButtonVisibility(true); // Switch to edit mode
    setFieldsState(false); // Enable fields
  });

  cancelBtn.onclick = () => {
    toggleButtonVisibility(false); // Switch back to view mode
    setFieldsState(true); // Disable fields
  };
}

function editDetails() {
  const textAreas = document.querySelectorAll('#editDetails textarea');
  const pDetails = document.querySelectorAll('.result-message');
  const updateDetails = document.getElementById('updateDetails');
  const updateSubmit = document.getElementById('details-update');
  const cancelUpdate = document.getElementById('cancel-btn');

  // Initialize display states
  pDetails.forEach((field) => (field.style.display = 'block'));
  textAreas.forEach((field) => (field.style.display = 'none'));
  updateSubmit.style.display = 'none';
  cancelUpdate.style.display = 'none';

  updateDetails.onclick = () => {
    // Show text areas and buttons for editing
    pDetails.forEach((field) => (field.style.display = 'none'));
    textAreas.forEach((field) => (field.style.display = 'block'));
    updateSubmit.style.display = 'block';
    cancelUpdate.style.display = 'block';
    updateDetails.style.display = 'none';
  };

  cancelUpdate.onclick = () => {
    // Reset to view mode
    pDetails.forEach((field) => (field.style.display = 'block'));
    textAreas.forEach((field) => (field.style.display = 'none'));
    updateSubmit.style.display = 'none';
    cancelUpdate.style.display = 'none';
    updateDetails.style.display = 'block';
  };
}
