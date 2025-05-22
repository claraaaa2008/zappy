var usr = [0, 0, 0];
var sist = [0, 0, 0];
var cantPartidas = 1;
var ganadas = 0;
var perdidas = 0;

function asignacionSist() { // devuelve arrat con eleccion del sistema
    var sist = [1, 0, 0]; // definir el array con la eleccion
    sist.sort(function (a, b) { return 0.5 - Math.random() }); // mezcla los valores, dando una eleccion al azar
    return sist;
}

function partida(eleccion) {
    if (ganadas < 3 && perdidas < 3) {
        animarMano();

        // Esperar 1 segundo antes de jugar
        setTimeout(() => {
            resolverJugada(eleccion);
        }, 1000);
    }
}

function resolverJugada(eleccion) {
    usr = [0, 0, 0];
    sist = asignacionSist();
    usr[eleccion] = 1;

    var ganador = quienGana();
    cambiarMano(sist, "sist");
    cambiarMano(usr, "usr");

    var mensaje = "";
    switch (ganador) {
        case "empate":
            mensaje = "Ha sido un empate, se repite la ronda";
            break;
        case "usr":
            mensaje = "Ganaste la ronda";
            cantPartidas++;
            ganadas++;
            break;
        case "sist":
            mensaje = "Perdiste la ronda";
            cantPartidas++;
            perdidas++;
            break;
    }

    document.getElementById("contUsr").textContent = "Tus puntos: " + ganadas + "/3";
    document.getElementById("contSist").textContent = "Puntos de Zappy: " + perdidas + "/3";
    document.getElementById("mensaje").textContent = mensaje;

    if (ganadas == 3) {
        document.getElementById("mensaje").textContent = "Felicitaciones ganaste el juego!!!";
        finJuego("usr");
    }
    if (perdidas == 3) {
        document.getElementById("mensaje").textContent = "Perdiste el juego ";
        finJuego("zappy");
    }
}


function quienGana() {
    var numUsr, numSist; // numUsr y numSist son la posicion en la que hay 1
    var ganador = "";
    for (var i = 0; i < 3; i++) {
        if (usr[i] == 1) {
            numUsr = i;
        }
        if (sist[i] == 1) {
            numSist = i;
        }
    }
    if (numSist == numUsr) {
        ganador = "empate";
    }
    if (numUsr == 0 && numSist == 1 ||
        numUsr == 1 && numSist == 2 ||
        numUsr == 2 && numSist == 0) {
        ganador = "sist";
    }
    if (numUsr == 0 && numSist == 2 ||
        numUsr == 1 && numSist == 0 ||
        numUsr == 2 && numSist == 1) {
        ganador = "usr";
    }
    return ganador;
}

function cambiarMano(aCambiar, queCambiar) {
    var valor = "";
    if (queCambiar == "sist") {
        switch (aCambiar.toString()) {
            case "1,0,0":
                valor = "img/ZappyConPiedra.png";
                break;
            case "0,1,0":
                valor = "img/ZappyConPapel.png";
                break;
            case "0,0,1":
                valor = "img/ZappyConTijera.png";
                break;
        }
        document.getElementById("zappy").src = valor;
    } else {
        switch (aCambiar.toString()) {
            case "1,0,0":
                valor = "img/manoPiedra.png";
                break;
            case "0,1,0":
                valor = "img/manoPapel.png";
                break;
            case "0,0,1":
                valor = "img/manoTijera.png";
                break;
        }
        document.getElementById("mano").src = valor;
    }
}

function finJuego(quienGano) {
    setTimeout(() => {
        if (quienGano == "zappy") {
            document.getElementById("modal-titulo").textContent = "¡Te gané! ¿Querés la revancha? ✌️";
        } else {
            document.getElementById("modal-titulo").textContent = "¡¡¡Felicitaciones ganaste!!! 🎉";
        };
        document.getElementById("resultado").textContent = "Tú: " + ganadas + " | Zappy: " + perdidas;
        document.getElementById("jugadas").textContent = "Rondas jugadas: " + cantPartidas;
        var modal = new bootstrap.Modal(document.getElementById('modalResumen'));
        modal.show();
    }, 1000);

}

function animarMano() {
    const mano = document.getElementById("mano");

    // Reiniciar animación
    mano.classList.remove("mano-animada");
    void mano.offsetWidth; // truquito para reiniciar
    mano.src = "img/manoPiedra.png";
    mano.classList.add("mano-animada");
}
