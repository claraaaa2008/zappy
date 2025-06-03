var modal = document.getElementById("modal01");
function abrirModal() {
    modal.style.display = "block";
}
function cerrar() {
    modal.style.display = "none";
}
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}