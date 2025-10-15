function fill_icons(event) {
    // Vacía todos los íconos primero
    document.querySelectorAll('.material-symbols-rounded').forEach(icon => {
        icon.style.fontVariationSettings = "'FILL' 0";
    });
    // Llena solo el ícono clickeado
    event.target.style.fontVariationSettings = "'FILL' 1";
}

// Selecciona todos los modales y botones de cerrar
const modals = document.querySelectorAll('.modal');
const closeBtns = document.querySelectorAll('.close');

// Abrir modal de eliminar cuenta
const openEliminarBtn = document.getElementById("openModalDelete");
openEliminarBtn.addEventListener("click", (e) => {
    e.preventDefault();
    // Abre el último modal (el de eliminar cuenta)
    modals[modals.length - 1].style.display = "flex";
});

// Cerrar cualquier modal con su botón de cerrar
closeBtns.forEach((btn, idx) => {
    btn.addEventListener("click", () => {
        // Cierra el modal correspondiente al botón
        modals[idx].style.display = "none";
    });
});

// Cerrar el modal si se hace click fuera del contenido
modals.forEach(modal => {
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});

const logoutIcon = document.getElementById("icon-logout");
logoutIcon.addEventListener("click", (e) => {
    e.preventDefault();
    // Abre el primer modal (el de logout, si es el primero en el DOM)
    modals[0].style.display = "flex";
});

document.getElementById("icon-person").style.fontVariationSettings = "'FILL' 1";