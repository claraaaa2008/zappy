// la computadora lee al usuario
const vasos = document.querySelectorAll('.vaso');
const pelota = document.getElementById('pelota');
const reiniciar = document.getElementById('reiniciar');
const mensaje = document.getElementById('mensaje');

// Se esconde la pelota (Vaso 1, 2 o 3)
let posicionPelota = Math.floor(Math.random() * 3);
let juegoActivo = true; 

// Oculta la pelota visualmente
function ocultarPelota() {
    pelota.style.display = 'none';
}

// Muestra la pelota justo debajo del vaso correcto
function mostrarPelotaEn(indice) {
    const vaso = vasos[indice];
    const rect = vaso.getBoundingClientRect();
    const juegoRect = document.getElementById('juego').getBoundingClientRect();

    // Calculamos la posición horizontal donde colocar la pelota
    pelota.style.left = (rect.left - juegoRect.left + vaso.offsetWidth / 2 - 25) + 'px';
    pelota.style.display = 'block';
}

// Muestra un mensaje al jugador si es correcto o incorrecto
function mostrarMensaje(texto, correcto) {
    mensaje.textContent = texto;
    mensaje.style.color = correcto ? 'lime' : 'red';
    mensaje.classList.add('mostrar');

    // Oculta el mensaje después de 2 segundos (2000 esta calculado en milisegundos)
    setTimeout(() => {
        mensaje.classList.remove('mostrar');
    }, 2000);
}

// Limpia el estado del juego para volver a jugar
function limpiarJuego() {
    mensaje.textContent = '';
    ocultarPelota();
    vasos.forEach(v => v.classList.remove('levantado'));
    juegoActivo = true;
}

// Clicks del usuario en los vasos
vasos.forEach((vaso, index) => { 
    vaso.addEventListener('click', () => {  
        if (!juegoActivo) return; 

        vasos.forEach(v => v.classList.remove('levantado')); // Baja todos los vasos
        vaso.classList.add('levantado'); // Levanta el vaso clickeado

        if (index == posicionPelota) { // Verifica si el vaso clickeado es el correcto
            mostrarPelotaEn(index); //muestra la pelota
            mostrarMensaje('¡Correcto! La pelota está aquí.', true); // muestra el mensaje correcto y se termina el juego
            juegoActivo = false; // Termina el turno
        } else {
            mostrarMensaje('¡Incorrecto! Intenta de nuevo.', false); //muestra el mensaje incorrecto y sigue el juego
        }
    });
});

//  Es para reiniciar el juego y esconder la pelota
reiniciar.addEventListener('click', () => {
    limpiarJuego();
    posicionPelota = Math.floor(Math.random() * 3); // Reasigna la posición aleatoria
});

// Inicialmente, la pelota está oculta
ocultarPelota();