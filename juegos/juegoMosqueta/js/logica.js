document.addEventListener('DOMContentLoaded', () => {
    const vasos = document.querySelectorAll('.vaso');
    const pelota = document.getElementById('pelota');
    const reiniciar = document.getElementById('reiniciar');
    const mensaje = document.getElementById('mensaje');
    const puntajeDisplay = document.getElementById('puntaje');

    let posicionPelota = Math.floor(Math.random() * 3);
    let juegoActivo = true;
    let puntaje = 0;

    // Cargar puntaje acumulado del usuario para este juego
    /*
    fetch('../../persistencia/obtenerPuntaje.php?id_juego=5')
        .then(res => res.json())
        .then(data => {
            if (data && data.puntaje !== undefined) {
                puntaje = data.puntaje;
                actualizarPuntaje();
            }
        })
        .catch(err => console.error('Error al cargar puntaje:', err));*/

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
        puntaje = 0;
        actualizarPuntaje();
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

                // Enviar puntaje al servidor si acierta
                fetch('../../persistencia/guardarPuntaje.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id_juego: 5,
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
                mostrarMensaje('¡Incorrecto! Intenta de nuevo.', false);
            }
        });
    });

    reiniciar.addEventListener('click', () => {
        limpiarJuego();
        posicionPelota = Math.floor(Math.random() * 3);
    });

    ocultarPelota();
    actualizarPuntaje();
});
