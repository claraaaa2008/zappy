document.addEventListener("DOMContentLoaded", function () {
  // =============================
  // Guardar cambios de usuario (AJAX)
  // =============================
  const formUsuario = document.getElementById("form-usuario");
  if (formUsuario) {
    formUsuario.addEventListener("submit", function (e) {
      e.preventDefault();
      const data = new FormData(formUsuario);

      fetch(formUsuario.action, {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((res) => alert(res.message))
        .catch((err) => console.error(err));
    });
  }

  // =============================
  // Cambiar contraseña (AJAX)
  // =============================
  const formContrasena = document.getElementById("form-contrasena");
  if (formContrasena) {
    formContrasena.addEventListener("submit", function (e) {
      e.preventDefault();
      const data = new FormData(formContrasena);

      fetch(formContrasena.action, {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((res) => alert(res.message))
        .catch((err) => console.error(err));
    });
  }

  // =============================
  // Inicialización de iconos y secciones
  // =============================
  document.getElementById("icon-person").style.fontVariationSettings = "'FILL' 1";
  document.getElementById("usuario").style.display = "block";
  document.getElementById("interfaz").style.display = "none";
  document.getElementById("admin").style.display = "none";

  // =============================
  // Foto de perfil
  // =============================
  const botonCambiarFoto = document.getElementById("boton-cambiar-foto");
  const inputFotoPerfil = document.getElementById("input-foto-perfil");
  const fotoPerfil = document.getElementById("foto-perfil-ajustes");
  const fotoHeader = document.getElementById("foto-perfil-header");

  if (botonCambiarFoto && inputFotoPerfil) {
    botonCambiarFoto.addEventListener("click", () => inputFotoPerfil.click());

    inputFotoPerfil.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const formData = new FormData();
        formData.append("fotoPerfil", file);

        fetch("php/cambiarInfoUsuario.php", {
          method: "POST",
          body: formData,
        })
          .then((res) => res.json())
          .then((res) => {
            if (res.success) {
              const nuevaFoto = "../../img/perfiles/" + res.foto + "?t=" + new Date().getTime();
              fotoPerfil.src = nuevaFoto;
              fotoHeader.src = nuevaFoto;
              alert("Foto de perfil actualizada!");
            } else {
              alert(res.message);
            }
          })
          .catch((err) => console.error(err));
      }
    });
  }

  // =============================
  // Funciones administrador: buscar usuario
  // =============================
  const inputBuscar = document.getElementById("usuarioBuscar");
  const usuarios = document.querySelectorAll(".usuario");
  if (inputBuscar) {
    inputBuscar.addEventListener("input", function () {
      const filtro = inputBuscar.value.toLowerCase();
      usuarios.forEach((usuario) => {
        const nombreEl = usuario.querySelector(".nomUsr");
        if (!nombreEl) return;
        const nombre = nombreEl.textContent.toLowerCase();
        usuario.style.display = nombre.includes(filtro) ? "flex" : "none";
      });
    });
  }

  // =============================
  // Escuchar solo formularios .form-admin-usuario
  // =============================
  document.addEventListener("submit", function (e) {
    const form = e.target;
    if (!form.classList.contains("form-admin-usuario")) return; // Ignora otros forms

    e.preventDefault();
    alert("Listener activado - AJAX en marcha");

    const fd = new FormData(form);

    fetch("php/actualizarUsuarioAdmin.php", {
      method: "POST",
      body: fd,
      credentials: "same-origin",
      headers: { "X-Requested-With": "XMLHttpRequest" },
    })
      .then((res) => {
        if (!res.ok) throw new Error("HTTP error: " + res.status);
        return res.json();
      })
      .then((json) => {
        alert(json.message || "Actualizado");
        if (json.success) {
          fetch("php/listarUsuarios.php")
            .then((r) => r.text())
            .then((html) => {
              document.getElementById("listaUsuarios").innerHTML = html;
            })
            .catch((err) => console.error("Error recargando lista:", err));
        }
      })
      .catch((err) => {
        console.error("Error en fetch:", err);
        alert("Error de red: " + err.message);
      });
  });
});

// =============================
// Funciones de modales
// =============================
function abrirModal(id, e) {
  if (e) e.preventDefault();
  const modal = document.getElementById(id);
  if (modal) {
    modal.style.display = "flex";
    modal.onclick = function (ev) {
      if (ev.target === modal) modal.style.display = "none";
    };
  }
}

function cerrarModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.style.display = "none";
}

// =============================
// Navegación entre secciones
// =============================
function fill_icons(event) {
  document.querySelectorAll(".material-symbols-rounded").forEach((icon) => {
    icon.style.fontVariationSettings = "'FILL' 0";
  });
  event.target.style.fontVariationSettings = "'FILL' 1";

  document.querySelectorAll("main section").forEach((section) => {
    section.style.display = "none";
  });

  if (event.target.id === "icon-person")
    document.getElementById("usuario").style.display = "block";
  if (event.target.id === "icon-ui")
    document.getElementById("interfaz").style.display = "block";
  if (event.target.id === "icon-admin")
    document.getElementById("admin").style.display = "flex";
}

// =============================
// Funciones administrador: Hacer admin / Activar-Desactivar
// =============================
document.addEventListener("click", async (e) => {
  // 🔹 Hacer admin
  if (e.target.matches(".buttonTurquesa") && e.target.textContent.includes("Hacer admin")) {
    const card = e.target.closest(".usuario");
    const idUsr = card.querySelector("input[name='idUsr']").value;

    const res = await fetch("php/hacerAdmin.php", {
      method: "POST",
      body: new URLSearchParams({ idUsr }),
    });
    const data = await res.json();

    if (data.success) {
      e.target.textContent = "Ya es admin";
      e.target.disabled = true;
      e.target.style.opacity = "0.6";
      e.target.style.fontStyle = "italic";
    } else {
      alert("Error al hacer admin");
    }
  }

  // 🔹 Activar / Desactivar usuario
  if (e.target.matches(".buttonRojo")) {
    const card = e.target.closest(".usuario");
    const idUsr = card.querySelector("input[name='idUsr']").value;

    const res = await fetch("php/desactivarUsuario.php", {
      method: "POST",
      body: new URLSearchParams({ idUsr }),
    });
    const data = await res.json();

    if (data.success) {
      if (data.nuevoEstado === 1) {
        e.target.textContent = "Desactivar";
        card.querySelector(".nomUsr").style.textDecoration = "none";
        const inactiveLabel = card.querySelector(".nomUsr span");
        if (inactiveLabel) inactiveLabel.remove();
      } else {
        e.target.textContent = "Reactivar";
        card.querySelector(".nomUsr").style.textDecoration = "line-through";
        if (!card.querySelector(".nomUsr span")) {
          card.querySelector(".nomUsr").insertAdjacentHTML(
            "beforeend",
            '<span style="color:red; font-size:0.9em;"> (inactivo)</span>'
          );
        }
      }
    } else {
      alert("Error al cambiar el estado del usuario");
    }
  }
});


document.addEventListener('DOMContentLoaded', function() {
    const clearSearchBtn = document.getElementById('clearSearch');
    const inputBuscar = document.getElementById('usuarioBuscar');
    const usuarios = document.querySelectorAll('.usuario');

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            inputBuscar.value = '';
            // Mostrar todos los usuarios nuevamente
            usuarios.forEach(usuario => {
                usuario.style.display = 'flex';
            });
        });
    }
});