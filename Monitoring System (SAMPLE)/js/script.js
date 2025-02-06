document.addEventListener('DOMContentLoaded', () => {
    navigationMenu();
    resetBtn();
})

function navigationMenu() {

    const hamBurger = document.querySelector(".toggle_btn");

    hamBurger.addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("expand");
    });

}

function resetBtn() {
    const resetBtn = document.getElementById('resetBtn');
    if(!resetBtn) return;

    resetBtn.onclick = () => {
        parent.location.href = "index.php";
    }
}