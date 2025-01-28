document.addEventListener('DOMContentLoaded', () => {
    navigationMenu();
    resetBtn();
    count();
    initSpinner();
    checkScreenWidth();
    cleanUrl();

})

window.addEventListener('resize', checkScreenWidth);

function checkScreenWidth() {
    // Only redirect if the width is less than 769px and not already on the access page
    if (window.innerWidth < 769 && !window.location.pathname.includes('access.html')) {
        // Redirect to access.html
        window.location.href = "access.html"; // Absolute URL or relative path if appropriate
    }
}

// Function to clean the URL
function cleanUrl() {
    const currentPath = window.location.href;

    //  Only clean URLs with 'index.php?page='
    if (currentPath.includes('index.php?page=')) {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page');

        // Ensure 'page' parameter exists
        if (page) {
            const newUrl = `${window.location.origin}/${page}`;

            //   Update the URL without reloading the page
            if (currentPath !== newUrl) {
                history.replaceState(null, '', newUrl);
                console.log('URL cleaned to:', newUrl);
            }
        }
    } else {
        console.log('URL is already clean:', currentPath);
    }

    if (currentPath.includes('history.php?assets_id=')) {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('assets_id');

        // Ensure 'page' parameter exists
        if (page) {
            const newUrl = `${window.location.origin}/${page}`;

            //   Update the URL without reloading the page
            if (currentPath !== newUrl) {
                history.replaceState(null, '', newUrl);
                console.log('URL cleaned to:', newUrl);
            }
        }
    } else {
        console.log('URL is already clean:', currentPath);
    }

    if (currentPath.includes('view.php?employee_id=')) {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('employee_id');

        // Ensure 'page' parameter exists
        if (page) {
            const newUrl = `${window.location.origin}/${page}`;

            //   Update the URL without reloading the page
            if (currentPath !== newUrl) {
                history.replaceState(null, '', newUrl);
                console.log('URL cleaned to:', newUrl);
            }
        }
    } else {
        console.log('URL is already clean:', currentPath);
    }
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

