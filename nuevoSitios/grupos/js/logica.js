fetch("../grupos/apiGrupo.php?action=crear", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
        nomGrupo: "Admins",
        descripcionGrupo: "Grupo de administradores",
        fechaCreacion: "2025-10-13",
        estadoGrupo: "Activo",
        tipoUsr: "Administrador"
    })
})
    .then(r => r.json())
    .then(console.log);
fetch("../grupos/apiGrupo.php?action=listar")
    .then(r => r.json())
    .then(console.table);
fetch("../grupos/apiGrupo.php?action=actualizar", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
        idGrupo: 1,
        nomGrupo: "Admins Update",
        descripcionGrupo: "Actualizado",
        estadoGrupo: "Inactivo",
        tipoUsr: "Usuario"
    })
})
    .then(r => r.json())
    .then(console.log);
fetch("../grupos/apiGrupo.php?action=eliminar", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ idGrupo: 1 })
})
    .then(r => r.json())
    .then(console.log);
