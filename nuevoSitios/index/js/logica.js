document.addEventListener('DOMContentLoaded', function() {
    const btnGris = document.querySelector('.buttonGris');
    if (btnGris) {
        btnGris.addEventListener('click', function(e) {
            e.preventDefault();
            document.body.classList.add('fade-out');
            setTimeout(() => {
                window.location.href = 'indexGame.html';
            }, 500); // Debe coincidir con la duración de la animación
        });
    }
});

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