document.addEventListener('DOMContentLoaded', () => {
    const vasos = document.querySelectorAll('.vaso');
    const pelota = document.getElementById('pelota');
    const reiniciar = document.getElementById('reiniciar');
    const mensaje = document.getElementById('mensaje');
    const puntajeDisplay = document.getElementById('puntaje');

    let posicionPelota = Math.floor(Math.random() * 3);
    let juegoActivo = true;
    let puntaje = 0;

    function ocultarPelota() {
        pelota.style.display = 'none';
    }

    function mostrarPelotaEn(indice) {
        const vaso = vasos[indice];
        const rect = vaso.getBoundingClientRect();
        const juegoRect = document.getElementById('juego').getBoundingClientRect();
        pelota.style.left = (rect.left - juegoRect.left + vaso.offsetWidth / 2 - 25) + 'px';
        pelota.style.display = 'block';
    }

    function mostrarMensaje(texto, correcto) {
        mensaje.textContent = texto;
        mensaje.style.color = correcto ? 'lime' : 'red';
        mensaje.classList.add('mostrar');
        setTimeout(() => {
            mensaje.classList.remove('mostrar');
        }, 2000);
    }

    function actualizarPuntaje() {
        puntajeDisplay.textContent = `Puntaje: ${puntaje}`;
    }

    function limpiarJuego() {
        mensaje.textContent = '';
        ocultarPelota();
        vasos.forEach(v => v.classList.remove('levantado'));
        juegoActivo = true;
    }

    vasos.forEach((vaso, index) => {
        vaso.addEventListener('click', () => {
            if (!juegoActivo) return;

            vasos.forEach(v => v.classList.remove('levantado'));
            vaso.classList.add('levantado');

            if (index == posicionPelota) {
                mostrarPelotaEn(index);
                mostrarMensaje('¡Correcto! La pelota está aquí.', true);
                puntaje++;
                console.log("Puntaje actualizado:", puntaje);
                actualizarPuntaje();
                juegoActivo = false;
            } else {
                mostrarMensaje('¡Incorrecto! Intenta de nuevo.', false);
            }
        });
    });

    reiniciar.addEventListener('click', () => {
        // Comentamos para no reiniciar el puntaje
        // puntaje = 0;
        // actualizarPuntaje();
        limpiarJuego();
        posicionPelota = Math.floor(Math.random() * 3);
    });

    ocultarPelota();
    actualizarPuntaje();
});
