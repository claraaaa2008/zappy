document.addEventListener('DOMContentLoaded', () => {
    const totalCards = 24;
    const totalPairs = totalCards / 2;
    const maxScore = 100;

    let cards = [];
    let selectedCards = [];
    let currentMove = 0;
    let currentAttempts = 0;
    let matchedPairs = 0;

    // NUEVA variable de puntaje acumulado
    let score = 0;
    // puntos por par (distribuye maxScore entre todos los pares)
    const pointsPerPair = Math.round(maxScore / totalPairs);

    const scoreEl = document.querySelector('#score');
    const statsEl = document.querySelector('#stats');
    const gameEl = document.querySelector('#game');

    // Inicializar UI
    if (scoreEl) scoreEl.textContent = 'Puntaje: 0';
    if (statsEl) statsEl.textContent = '0 intentos';

    // Música (toggle con botón existente)
    const playBtn = document.getElementById('play-music');
    const audioEl = document.getElementById('bg-music');
    if (playBtn && audioEl) {
        let isMusicPlaying = !audioEl.paused && !audioEl.muted;

        const updateMusicButtonUI = () => {
            playBtn.setAttribute('aria-pressed', isMusicPlaying ? 'true' : 'false');
            playBtn.title = isMusicPlaying
                ? 'Música: encendida (clic para apagar)'
                : 'Música: apagada (clic para encender)';
            const img = playBtn.querySelector('img');
            if (img) img.style.opacity = isMusicPlaying ? '1' : '0.5';
        };

        updateMusicButtonUI();

        playBtn.addEventListener('click', () => {
            if (audioEl.paused) {
                audioEl.play().catch(() => { /* bloqueo automático */ });
                isMusicPlaying = true;
            } else {
                audioEl.pause();
                isMusicPlaying = false;
            }
            updateMusicButtonUI();
        });
    }

    const cardTemplate = '<div class="card"><div class="back"></div><div class="face"></div></div>';

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    // Actualiza el puntaje mostrado usando la variable acumulada `score`
    function updateScoreUI() {
        if (!scoreEl) return;
        scoreEl.textContent = 'Puntaje: ' + score;
    }

    function activate(e) {
        const clicked = e.currentTarget;

        if (currentMove < 2 && !clicked.classList.contains('active')) {
            clicked.classList.add('active');

            if (!selectedCards[0] || selectedCards[0] !== clicked) {
                selectedCards.push(clicked);
                currentMove++;

                if (currentMove === 2) {
                    currentAttempts++;
                    if (statsEl) statsEl.textContent = currentAttempts + ' intentos';

                    const val1 = selectedCards[0].querySelector('.face').textContent.trim();
                    const val2 = selectedCards[1].querySelector('.face').textContent.trim();

                    if (val1 === val2) {
                        matchedPairs++;

                        // --- Aquí sumamos puntos por par y actualizamos UI ---
                        score += pointsPerPair;
                        if (score > maxScore) score = maxScore; // tope por si sobra
                        updateScoreUI();
                        // ----------------------------------------------------

                        selectedCards = [];
                        currentMove = 0;

                        if (matchedPairs === totalPairs) {
                            // Si querés mostrar el puntaje final exacto (ya está en score)
                            if (scoreEl) scoreEl.textContent = 'Puntaje: ' + score;

                            // Deshabilitar clicks después de ganar
                            cards.forEach(card => card.removeEventListener('click', activate));

                            // Enviar puntaje al servidor (si corresponde)
                            fetch('guardarPuntaje.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({
                                    id_juego: 1,
                                    puntaje: score
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

                            setTimeout(() => {
                                alert('🎉 ¡Ganaste! Tu puntaje final es: ' + score);
                            }, 500);
                        }
                    } else {
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

    // Generar valores de las cartas (2 de cada uno)
    let values = [];
    for (let i = 0; i < totalPairs; i++) {
        values.push(i);
        values.push(i);
    }

    values = shuffle(values);

    for (let i = 0; i < totalCards; i++) {
        const div = document.createElement('div');
        div.innerHTML = cardTemplate;

        const card = div.firstChild;
        const face = card.querySelector('.face');
        if (face) face.innerHTML = values[i];

        card.addEventListener('click', activate);
        cards.push(card);
        if (gameEl) gameEl.appendChild(card);
    }
});
