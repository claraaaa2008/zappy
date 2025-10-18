function abrirModal(id, e) {
    if (e) e.preventDefault();
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'flex';
        // Cerrar el modal solo al hacer click fuera del contenido interno
        modal.onclick = function(ev) {
            if (ev.target === modal) {
                modal.style.display = 'none';
            }
        };
    }
}

function cerrarModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'none';
    }
}