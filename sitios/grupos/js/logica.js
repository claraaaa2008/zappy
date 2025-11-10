document.addEventListener("DOMContentLoaded", () => {
    const API = "php/apiGrupo.php";

    const btnCrear = document.getElementById("btnCrear");
    const nombreGrupo = document.getElementById("nombreGrupo");
    const descripcion = document.getElementById("descripcion");

    const btnUnirse = document.getElementById("btnUnirse");
    const codigoGrupo = document.getElementById("codigoGrupo"); 

    const contenedorMisGrupos = document.getElementById("misGruposList");

    // CREAR GRUPO
    btnCrear.addEventListener("click", async () => {
        const data = { nomGrupo: nombreGrupo.value, descripcionGrupo: descripcion.value };
        try {
            const res = await fetch(`${API}?action=crear`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });
            const result = await res.json();
            if(result.success) {
                alert(`✅ Grupo creado. Código: ${result.codigo}`);
                nombreGrupo.value = ""; descripcion.value = "";
                cargarMisGrupos();
            } else alert("⚠️ " + result.message);
        } catch(e){ console.error(e); alert("❌ Error de conexión"); }
    });

    // UNIRSE A GRUPO
    btnUnirse.addEventListener("click", async () => {
        const data = { codigoGrupo: codigoGrupo.value };
        try {
            const res = await fetch(`${API}?action=unirse`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });
            const result = await res.json();
            if(result.success) {
                alert(`✅ Te uniste al grupo`);
                codigoGrupo.value = "";
                cargarMisGrupos();
            } else alert("⚠️ " + result.message);
        } catch(e){ console.error(e); alert("❌ Error de conexión"); }
    });

    // CARGAR MIS GRUPOS
    async function cargarMisGrupos() {
        try {
            const res = await fetch(`${API}?action=misGrupos`);
            const result = await res.json();
            contenedorMisGrupos.innerHTML = "";

            if(result.success && result.grupos.length > 0){
                result.grupos.forEach(grupo => {
                    const div = document.createElement("div");
                    div.className = "grupo-item";
                    div.innerHTML = `
                        <h4>${grupo.nomGrupo} (${grupo.codigoGrupo})</h4>
                        <p>${grupo.descripcion}</p>
                        <strong>Miembros:</strong> ${grupo.miembros.length ? grupo.miembros.join(", ") : "Solo tú"}
                    `;
                    contenedorMisGrupos.appendChild(div);
                });
            } else {
                contenedorMisGrupos.innerHTML = "<p>No perteneces a ningún grupo.</p>";
            }
        } catch(e){ console.error(e); contenedorMisGrupos.innerHTML = "<p>Error al cargar tus grupos.</p>"; }
    }

    cargarMisGrupos();
});
