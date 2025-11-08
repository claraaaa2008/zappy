

console.log("LOGICA.JS CARGÓ PERFECTAMENTE");

var puertas = asignacionPrimaria();
console.log(puertas);

var contEleccion = 0;
var eleccionPrimaria;

var puntaje = 0; // puntaje total

// Cargar puntaje acumulado del usuario para este juego
fetch('../../../persistencia/obtenerPuntaje.php?id_juego=4')
    .then(res => res.json())
    .then(data => {
        if (data && data.puntaje !== undefined) {
            puntaje = data.puntaje;
            document.querySelector("#puntaje").textContent = "Puntaje: " + puntaje;
        }
    })
    .catch(err => console.error('Error al cargar puntaje:', err));

function asignacionPrimaria() {
    var puertas = [1, 0, 0];
    puertas.sort(function (a, b) { return 0.5 - Math.random() });
    return puertas;
}

function elegirPuerta(eleccion) {
    const mensaje = document.getElementById("mensaje");
    console.log("Contador de elección: ", contEleccion);
console.log("Elegiste: ", eleccion);

    if (contEleccion == 0) {
        eleccionPrimaria = eleccion;

        do {
            var abro = Math.floor(Math.random() * 3);
            a = puertas[abro];

            if (abro == eleccion) {
                a = 1;
            }

            var abierta = abro;
        } while (a == 1);

        puertas[abierta] = 2;
        document.getElementById(abierta).disabled = true;
        document.getElementById(abierta).removeAttribute("onclick");
        document.getElementById(abierta).setAttribute("class", "puerta puertaAbierta");
        document.getElementById(eleccion).setAttribute("class", "puerta primeraEleccion");

        cambiarAbierta(abierta);
        console.log(puertas);

        contEleccion = 1;

        mensaje.textContent = `Elegiste la puerta ${eleccion + 1}. ¿Querés cambiar?`;
    } else {
        decisionFinal(eleccion);
    }
}

function cambiarAbierta(abierta) {
    document.getElementById(abierta).src = "../../img/juegoPuertas/puertaPerder.png";
}

function decisionFinal(eleccionFinal) {
    let perder = -1;
    let ganar = -1;

    for (let i = 0; i < 3; i++) {
        if (puertas[i] == 0) perder = i;
        if (puertas[i] == 1) ganar = i;
    }

    document.getElementById(ganar).src = "../../img/juegoPuertas/puertaPremio.png";
    document.getElementById(perder).src = "../../img/juegoPuertas/puertaPerder.png";

    const mensaje = document.getElementById("mensaje");

    if (eleccionFinal == ganar) {
        puntaje += 10;
        mensaje.textContent = `¡Felicidades! Encontraste a Zappy en la puerta ${ganar + 1}.`;
        // Enviar puntaje al servidor si gana
        fetch('../../../persistencia/guardarPuntaje.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id_juego: 4,
                puntaje: puntaje
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                console.log('Puntaje guardado correctamente');
            } else {
                console.error('Error al guardar puntaje:', data && data.error ? data.error : data);
            }
        })
        .catch(err => console.error('Error en fetch:', err));
    } else {
        puntaje += 2;
        mensaje.textContent = `Qué lástima... Zappy estaba en la puerta ${ganar + 1}.`;
    }

    // ✅ FORZAMOS actualización del puntaje SIN FALLAR
    const nodoPuntaje = document.querySelector("#puntaje");
    nodoPuntaje.textContent = "Puntaje: " + puntaje;

    // deshabilitar puertas
    for (let i = 0; i < 3; i++) {
        const p = document.getElementById(i);
        p.disabled = true;
        p.removeAttribute("onclick");
    }

    // botón para reiniciar
    mensaje.innerHTML += `<br><button onclick="reiniciarJuego()">Jugar de nuevo</button>`;
}

function reiniciarJuego() {
    // reiniciar variables de ronda (no resetea puntaje por defecto)
    puertas = asignacionPrimaria();
    contEleccion = 0;

    // reiniciar puertas visuales
    for (let i = 0; i < 3; i++) {
        const puerta = document.getElementById(i);
        puerta.src = "../../img/juegoPuertas/puertaCerrada.png";
        puerta.className = "puerta";
        puerta.disabled = false;
        puerta.setAttribute("onclick", `elegirPuerta(${i})`);
    }

    document.getElementById("mensaje").textContent = "¡Elige una puerta y encuentra a Zappy!";

    // si querés reiniciar el puntaje al volver a jugar descomenta la línea siguiente:
    // puntaje = 0; document.getElementById("puntaje").textContent = "Puntaje: " + puntaje;

    console.log(puertas);
}
