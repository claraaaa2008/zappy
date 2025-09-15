document.addEventListener('DOMContentLoaded', () => {
    // --- Configuración inicial del juego ---
    const totalCards = 24;           // Número total de cartas
    const totalPairs = totalCards / 2; // Cantidad de pares (12 en este caso)
    const maxScore = 100;            // Puntaje máximo posible

    // Variables de estado del juego
    let cards = [];                  // Array donde se guardan las cartas creadas
    let selectedCards = [];          // Almacena las cartas seleccionadas temporalmente
    let currentMove = 0;             // Movimientos dentro de un turno (máximo 2 cartas)
    let currentAttempts = 0;         // Número de intentos realizados
    let matchedPairs = 0;            // Pares encontrados correctamente

    // --- Control de música ---
    document.getElementById('play-music').addEventListener('click', () => {
        const music = document.getElementById('bg-music');
        music.play(); // Inicia la música al hacer clic en el botón
    });

    // Plantilla de carta en HTML
    const cardTemplate = '<div class="card"><div class="back"></div><div class="face"></div></div>';

    // --- Función para mezclar aleatoriamente un array (Fisher-Yates shuffle) ---
    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    // --- Cálculo del puntaje ---
    function calculateScore() {
        let efficiency = totalPairs / currentAttempts;  // Eficiencia = pares totales / intentos
        let score = Math.round(maxScore * efficiency);  // Puntaje proporcional a la eficiencia
        return score > 0 ? score : 0; // Nunca retorna puntaje negativo
    }

    // --- Función que se activa al hacer clic en una carta ---
    function activate(e) {
        const clicked = e.currentTarget; // La carta que se clickeó

        // Solo permite girar 2 cartas y evita hacer clic en la misma carta
        if (currentMove < 2 && !clicked.classList.contains('active')) {
            clicked.classList.add('active'); // Se voltea la carta

            // Se agrega la carta seleccionada al array de seleccionadas
            if (!selectedCards[0] || selectedCards[0] !== clicked) {
                selectedCards.push(clicked);
                currentMove++;

                // Si se seleccionaron 2 cartas...
                if (currentMove === 2) {
                    currentAttempts++; // Se incrementa el número de intentos
                    document.querySelector('#stats').textContent = currentAttempts + ' intentos';

                    // Se comparan los valores de las dos cartas
                    const val1 = selectedCards[0].querySelector('.face').textContent.trim();
                    const val2 = selectedCards[1].querySelector('.face').textContent.trim();

                    if (val1 === val2) { 
                        // ¡Son iguales! Se confirma un par
                        matchedPairs++;
                        selectedCards = [];
                        currentMove = 0;

                        // Si encontró todos los pares, termina el juego
                        if (matchedPairs === totalPairs) {
                            const finalScore = calculateScore(); // Calcula puntaje final
                            document.querySelector('#score').textContent = 'Puntaje: ' + finalScore;

                            // Se deshabilitan los clics en todas las cartas
                            cards.forEach(card => card.removeEventListener('click', activate));

                            // --- Guardar puntaje en servidor vía PHP ---
                            fetch('../../persistencia/guardarPuntaje.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({
                                    id_juego: 1,   // ID del juego (Memory = 1)
                                    puntaje: finalScore
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Puntaje guardado correctamente');
                                } else {
                                    console.error('Error al guardar puntaje:', data.error);
                                }
                            })
                            .catch(err => console.error('Error en fetch:', err));

                            // Mensaje de victoria
                            setTimeout(() => {
                                alert('🎉 ¡Ganaste! Tu puntaje final es: ' + finalScore);
                            }, 500);
                        }
                    } else {
                        // Si no coinciden, se voltean otra vez después de 0.8 segundos
                        setTimeout(() => {
                            selectedCards[0].classList.remove('active');
                            selectedCards[1].classList.remove('active');
                            selectedCards = [];
                            currentMove = 0;
                        }, 800);
                    }
                }
            }
        }
    }

    // --- Generación de valores para las cartas ---
    let values = [];
    for (let i = 0; i < totalPairs; i++) {
        values.push(i); // Se agrega cada número dos veces (para formar pares)
        values.push(i);
    }

    values = shuffle(values); // Se mezclan los valores

    // --- Creación de las cartas en el DOM ---
    for (let i = 0; i < totalCards; i++) {
        const div = document.createElement('div');
        div.innerHTML = cardTemplate; // Se inserta la plantilla de carta

        const card = div.firstChild;
        card.querySelector('.face').innerHTML = values[i]; // Se asigna valor a la carta

        card.addEventListener('click', activate); // Se activa la función al hacer clic
        cards.push(card); // Se guarda en el array global
        document.querySelector('#game').appendChild(card); // Se inserta en el tablero
    }
});
