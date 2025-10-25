document.addEventListener('DOMContentLoaded', function () {

    // =============================
    // Guardar cambios de usuario (AJAX)
    // =============================
    const formUsuario = document.getElementById("form-usuario");
    formUsuario.addEventListener("submit", function (e) {
        e.preventDefault();
        const data = new FormData(formUsuario);

        fetch(formUsuario.action, {
            method: 'POST',
            body: data
        })
            .then(res => res.json())
            .then(res => alert(res.message))
            .catch(err => console.error(err));
    });

    // =============================
    // Cambiar contraseña (AJAX)
    // =============================
    const formContrasena = document.getElementById("form-contrasena");
    formContrasena.addEventListener("submit", function (e) {
        e.preventDefault();
        const data = new FormData(formContrasena);

        fetch(formContrasena.action, {
            method: 'POST',
            body: data
        })
            .then(res => res.json())
            .then(res => alert(res.message))
            .catch(err => console.error(err));
    });

    // =============================
    // Inicialización de iconos y secciones
    // =============================
    document.getElementById('icon-person').style.fontVariationSettings = "'FILL' 1";
    document.getElementById('usuario').style.display = 'block';
    document.getElementById('interfaz').style.display = 'none';

    // =============================
    // Foto de perfil
    // =============================
    const botonCambiarFoto = document.getElementById("boton-cambiar-foto");
    const inputFotoPerfil = document.getElementById("input-foto-perfil");
    const fotoPerfil = document.getElementById("foto-perfil-ajustes");
    const fotoHeader = document.getElementById("foto-perfil-header");

    botonCambiarFoto.addEventListener("click", () => inputFotoPerfil.click());

    inputFotoPerfil.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            const formData = new FormData();
            formData.append("fotoPerfil", file); // nombre debe coincidir con PHP

            fetch("php/cambiarInfoUsuario.php", {
                method: "POST",
                body: formData
            })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        // Para evitar cache del navegador
                        const nuevaFoto = "../../img/perfiles/" + res.foto + "?t=" + new Date().getTime();
                        fotoPerfil.src = nuevaFoto;
                        fotoHeader.src = nuevaFoto;
                        alert("Foto de perfil actualizada!");
                    } else {
                        alert(res.message);
                    }
                })
                .catch(err => console.error(err));
        }
    });
});

// =============================
// Funciones de modales
// =============================
function abrirModal(id, e) {
    if (e) e.preventDefault();
    const modal = document.getElementById(id);
    if (modal) {
        modal.style.display = 'flex';
        modal.onclick = function (ev) {
            if (ev.target === modal) modal.style.display = 'none';
        }
    }
}

function cerrarModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.style.display = 'none';
}

// =============================
// Navegación entre secciones
// =============================
function fill_icons(event) {
    document.querySelectorAll('.material-symbols-rounded').forEach(icon => {
        icon.style.fontVariationSettings = "'FILL' 0";
    });
    event.target.style.fontVariationSettings = "'FILL' 1";

    document.querySelectorAll('main section').forEach(section => {
        section.style.display = 'none';
    });

    if (event.target.id === 'icon-person') document.getElementById('usuario').style.display = 'block';
    if (event.target.id === 'icon-ui') document.getElementById('interfaz').style.display = 'block';
}