// Variables globales para almacenar el estado del juego
var usr = [0, 0, 0];       // Array para la elección del usuario (piedra, papel o tijera)
var sist = [0, 0, 0];      // Array para la elección del sistema (zappy)
var cantPartidas = 1;      // Contador de partidas jugadas
var ganadas = 0;           // Cantidad de partidas ganadas por el usuario
var perdidas = 0;          // Cantidad de partidas ganadas por el sistema

// Función que genera la elección aleatoria del sistema
function asignacionSist() {
    var sist = [1, 0, 0]; // Define la elección inicial (piedra)
    // Mezcla el array aleatoriamente para elegir piedra, papel o tijera
    sist.sort(function (a, b) { return 0.5 - Math.random() });
    return sist; // Retorna la elección aleatoria
}

// Función que inicia una partida con la elección del usuario
function partida(eleccion) {
    // Solo permite jugar si no se ha llegado a 3 ganadas o perdidas
    if (ganadas < 3 && perdidas < 3) {
        animarMano(); // Ejecuta la animación de la mano

        // Espera 1 segundo antes de resolver la jugada para dar tiempo a la animación
        setTimeout(() => {
            resolverJugada(eleccion);
        }, 1000);
    }
}

// Función que resuelve la jugada y actualiza el estado del juego
function resolverJugada(eleccion) {
    usr = [0, 0, 0];        // Reinicia la elección del usuario
    sist = asignacionSist(); // Asigna la elección aleatoria del sistema
    usr[eleccion] = 1;       // Marca la elección del usuario en el array

    var ganador = quienGana(); // Determina quién gana esta ronda
    cambiarMano(sist, "sist"); // Cambia la imagen de la mano del sistema
    cambiarMano(usr, "usr");   // Cambia la imagen de la mano del usuario

    var mensaje = "";          // Variable para mensaje de resultado (no se usa en este código)
    switch (ganador) {
        case "empate":
            mensaje = "Ha sido un empate, se repite la ronda";
            break;
        case "usr":
            mensaje = "Ganaste la ronda";
            cantPartidas++;    // Aumenta el contador de partidas
            ganadas++;         // Aumenta las partidas ganadas por el usuario
            break;
        case "sist":
            mensaje = "Perdiste la ronda";
            cantPartidas++;    // Aumenta el contador de partidas
            perdidas++;        // Aumenta las partidas ganadas por el sistema
            break;
    }

    // Actualiza en pantalla el puntaje del usuario y del sistema
    document.getElementById("contUsr").textContent = ganadas;
    document.getElementById("contSist").textContent = perdidas;
    //document.getElementById("mensaje").textContent = mensaje; // Comentado, no muestra mensajes

    // Si el usuario o sistema llega a 3 puntos, termina el juego
    if (ganadas == 3) {
        finJuego("usr");
    }
    if (perdidas == 3) {
        finJuego("zappy");
    }
}

// Función que determina el ganador según la elección del usuario y del sistema
function quienGana() {
    var numUsr, numSist; // Variables para guardar la posición elegida (0, 1 o 2)
    var ganador = "";
    // Recorre el array para encontrar la posición donde está el 1 (elección)
    for (var i = 0; i < 3; i++) {
        if (usr[i] == 1) {
            numUsr = i;
        }
        if (sist[i] == 1) {
            numSist = i;
        }
    }
    // Si las elecciones son iguales, hay empate
    if (numSist == numUsr) {
        ganador = "empate";
    }
    // Condiciones en que gana el sistema
    if (numUsr == 0 && numSist == 1 ||
        numUsr == 1 && numSist == 2 ||
        numUsr == 2 && numSist == 0) {
        ganador = "sist";
    }
    // Condiciones en que gana el usuario
    if (numUsr == 0 && numSist == 2 ||
        numUsr == 1 && numSist == 0 ||
        numUsr == 2 && numSist == 1) {
        ganador = "usr";
    }
    return ganador; // Devuelve el ganador: "usr", "sist" o "empate"
}

// Función que cambia la imagen de la mano según la elección
// aCambiar es el array con la elección, queCambiar indica si es "usr" o "sist"
function cambiarMano(aCambiar, queCambiar) {
    var valor = ""; // Variable para guardar la ruta de la imagen
    if (queCambiar == "sist") {
        // Dependiendo de la elección del sistema, asigna la imagen correspondiente
        switch (aCambiar.toString()) {
            case "1,0,0":
                valor = "../img/piedraPapelTijera/ZappyConPiedra.png";
                break;
            case "0,1,0":
                valor = "../img/piedraPapelTijera/ZappyConPapel.png";
                break;
            case "0,0,1":
                valor = "../img/piedraPapelTijera/ZappyConTijera.png";
                break;
        }
        document.getElementById("zappy").src = valor; // Cambia la imagen de zappy
    } else {
        // Lo mismo pero para el usuario
        switch (aCambiar.toString()) {
            case "1,0,0":
                valor = "../img/piedraPapelTijera/manoPiedra.png";
                break;
            case "0,1,0":
                valor = "../img/piedraPapelTijera/manoPapel.png";
                break;
            case "0,0,1":
                valor = "../img/piedraPapelTijera/manoTijera.png";
                break;
        }
        document.getElementById("mano").src = valor; // Cambia la imagen de la mano del usuario
    }
}

// Función que muestra el modal con el resultado final del juego
function finJuego(quienGano) {
    setTimeout(() => {
        if (quienGano == "zappy") {
            document.getElementById("modal-titulo").textContent = "¡Te gané! ¿Querés la revancha? ✌️";
        } else {
            document.getElementById("modal-titulo").textContent = "¡¡¡Felicitaciones ganaste!!! 🎉";
        };
        // Muestra los puntajes finales y cantidad de rondas jugadas
        document.getElementById("resultado").textContent = "Tú: " + ganadas + " | Zappy: " + perdidas;
        document.getElementById("jugadas").textContent = "Rondas jugadas: " + cantPartidas;
        // Muestra el modal usando Bootstrap
        var modal = new bootstrap.Modal(document.getElementById('modalResumen'));
        modal.show();
    }, 1000);
}

// Función que anima la mano del usuario
function animarMano() {
    const mano = document.getElementById("mano");

    // Reinicia la animación quitando y agregando la clase
    mano.classList.remove("mano-animada");
    void mano.offsetWidth; // Truco para reiniciar la animación CSS
    mano.src = "img/manoPiedra.png"; // Cambia la imagen para reiniciar posición
    mano.classList.add("mano-animada"); // Agrega la clase que tiene la animación
}

