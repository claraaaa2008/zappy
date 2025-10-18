function abrirModal(id, e) {
    if (e) e.preventDefault();
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'flex';
        // Cerrar el modal solo al hacer click fuera del contenido interno
        modal.onclick = function (ev) {
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

function fill_icons(event) {
    // Vacía todos los íconos primero
    document.querySelectorAll('.material-symbols-rounded').forEach(icon => {
        icon.style.fontVariationSettings = "'FILL' 0";
    });
    // Llena solo el ícono clickeado
    event.target.style.fontVariationSettings = "'FILL' 1";

    // Oculta todas las secciones
    document.querySelectorAll('main section').forEach(section => {
        section.style.display = 'none';
    });

    // Muestra la sección correspondiente
    if (event.target.id === 'icon-person') {
        document.getElementById('usuario').style.display = 'block';
    } else if (event.target.id === 'icon-ui') {
        document.getElementById('interfaz').style.display = 'block';
    }
    // Para logout, las secciones permanecen ocultas
}

// Establecer por defecto el ícono de usuario lleno al cargar la página y mostrar la sección usuario
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('icon-person').style.fontVariationSettings = "'FILL' 1";
    document.getElementById('usuario').style.display = 'block';
    document.getElementById('interfaz').style.display = 'none';
});
