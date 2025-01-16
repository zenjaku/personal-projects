document.addEventListener('DOMContentLoaded', () => {
    loginForm();
    header();
    footer();
    dashboard();
    archived();
    userModal();
})

function header() {
    const header = document.getElementById('tomaraoHeader');

    if (!header) return;

    header.onclick = () => {
        parent.location.reload();
    }

    return;
}

function footer() {
    const footer = document.getElementById('tomaraoFooter');

    if (!footer) return;

    footer.onclick = () => {
        window.open("https://zenjakucreations.vercel.app/", "_blank");
    }

    return;
}

function loginForm() {
    const registerBtn = document.getElementById('registerBtn');
    const loginBtn = document.getElementById('loginBtn');
    const loginForm = document.getElementById('login');
    const registerForm = document.getElementById('register');

    if (!registerBtn || !loginBtn || !loginForm || !registerForm) return;

    registerForm.style.display = 'none';
    loginForm.style.display = 'block';

    registerBtn.onclick = () => {
        loginForm.style.display = 'none'
        registerForm.style.display = 'block'
    }

    loginBtn.onclick = () => {
        loginForm.style.display = 'block'
        registerForm.style.display = 'none'
    }

    return;
}

function dashboard() {
    const profile = document.getElementById('profile');
    const users = document.getElementById('users');
    const schoolInfo = document.getElementById('schoolInfo');
    const feedback = document.getElementById('feedback');
    const archived = document.getElementById('archived');

    const profileModal = document.getElementById('profileModal');
    const usersModal = document.getElementById('usersModal');
    const schoolModal = document.getElementById('schoolModal');
    const feedbacks = document.getElementById('feedbacks');
    const archivedModal = document.getElementById('archivedModal');

    if (!profile || !users || !schoolInfo || !feedback || !profileModal || !usersModal ||
        !schoolModal || !feedbacks || !archivedModal
    ) return;

    usersModal.style.display = 'none';
    schoolModal.style.display = 'none';
    feedbacks.style.display = 'none';
    archivedModal.style.display = 'none';
    profileModal.style.display = 'block';

    profile.onclick = () => {
        usersModal.style.display = 'none';
        schoolModal.style.display = 'none';
        feedbacks.style.display = 'none';
        archivedModal.style.display = 'none';
        profileModal.style.display = 'block';
    }

    users.onclick = () => {
        usersModal.style.display = 'block';
        schoolModal.style.display = 'none';
        feedbacks.style.display = 'none';
        archivedModal.style.display = 'none';
        profileModal.style.display = 'none';
    }

    schoolInfo.onclick = () => {
        usersModal.style.display = 'none';
        schoolModal.style.display = 'block';
        feedbacks.style.display = 'none';
        archivedModal.style.display = 'none';
        profileModal.style.display = 'none';
    }

    feedback.onclick = () => {
        usersModal.style.display = 'none';
        schoolModal.style.display = 'none';
        feedbacks.style.display = 'block';
        archivedModal.style.display = 'none';
        profileModal.style.display = 'none';
    }

    archived.onclick = () => {
        usersModal.style.display = 'none';
        schoolModal.style.display = 'none';
        feedbacks.style.display = 'none';
        archivedModal.style.display = 'block';
        profileModal.style.display = 'none';
    }
}

function archived() {
    const schoolData = document.getElementById('schoolData');
    const feedbackData = document.getElementById('feedbackData');

    const schoolArchived = document.getElementById('schoolArchived');
    const feedbackArchived = document.getElementById('feedbackArchived');

    if (!schoolData || !feedbackData || !schoolArchived || !feedbackArchived) return;

    // Initial state: hide all
    schoolArchived.style.display = 'none';
    feedbackArchived.style.display = 'none';

    let currentVisible = null; // Tracks the currently visible section

    const toggleDisplay = (target, section) => {
        if (currentVisible === section) {
            // If the same section is clicked, hide it
            target.style.display = 'none';
            currentVisible = null;
        } else {
            // Hide all and show the clicked section
            schoolArchived.style.display = 'none';
            feedbackArchived.style.display = 'none';

            target.style.display = 'block';
            currentVisible = section;
        }
    };

    // Attach click handlers
    schoolData.onclick = () => toggleDisplay(schoolArchived, 'school');
    feedbackData.onclick = () => toggleDisplay(feedbackArchived, 'feedback');
}


function userModal() {
    const profileBtn = document.getElementById('profileBtn');
    const userModal = document.getElementById('userModal');
    const addFeedback = document.getElementById('addFeedback');
    const feedbackModal = document.getElementById('feedbackModal');

    if (!userModal || !addFeedback || !feedbackModal) return;

    userModal.style.display = 'block'
    feedbackModal.style.display = 'none'

    profileBtn.onclick = () => {
        feedbackModal.style.display = 'none';
        userModal.style.display = 'block';
    }

    addFeedback.onclick = () => {
        feedbackModal.style.display = 'block';
        userModal.style.display = 'none';
    }
}