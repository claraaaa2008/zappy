const btnCrear = document.querySelector(".buttonTurquesa");
const inputNombre = document.getElementById("nombreGrupo");
const inputDescripcion = document.getElementById("descripcion");

btnCrear.addEventListener("click", () => {
    const nomGrupo = inputNombre.value.trim();
    const descripcion = inputDescripcion.value.trim();

    if (!nomGrupo) {
        alert("Ingrese el nombre del grupo");
        return;
    }

    const codigoGrupo = Math.random().toString(36).substring(2, 8).toUpperCase();
    const tipoUsr = "Administrador";
    const idCreador = 1; // cambiar al usuario logueado

    fetch("../php/apiGrupo.php?action=crear", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            nomGrupo,
            descripcion,
            codigoGrupo,
            tipoUsr,
            idCreador
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        listarGrupos();
    });
});

// Función para listar grupos
function listarGrupos() {
    fetch("../php/apiGrupo.php?action=listar")
        .then(res => res.json())
        .then(grupos => {
            console.table(grupos);
        });
}

// Listar al cargar la página
listarGrupos();
