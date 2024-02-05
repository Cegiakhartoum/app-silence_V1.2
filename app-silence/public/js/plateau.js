document
    .getElementById("montageLink")
    .addEventListener("click", function (event) {
        if (window.innerWidth <= 991) {
            event.preventDefault();
            openModal();
        }
    });

function openModal() {
    document.getElementById("modal").style.display = "block";
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}
