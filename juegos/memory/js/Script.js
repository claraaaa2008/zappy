document.addEventListener('DOMContentLoaded', () => {
    const totalCards = 24;
    const totalPairs = totalCards / 2;
    const maxScore = 100;

    let cards = [];
    let selectedCards = [];
    let currentMove = 0;
    let currentAttempts = 0;
    let matchedPairs = 0;

    // Música
    document.getElementById('play-music').addEventListener('click', () => {
        const music = document.getElementById('bg-music');
        music.play();
    });

    const cardTemplate = '<div class="card"><div class="back"></div><div class="face"></div></div>';

    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    function calculateScore() {
        let efficiency = totalPairs / currentAttempts;
        let score = Math.round(maxScore * efficiency);
        return score > 0 ? score : 0;
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
                    document.querySelector('#stats').textContent = currentAttempts + ' intentos';

                    const val1 = selectedCards[0].querySelector('.face').textContent.trim();
                    const val2 = selectedCards[1].querySelector('.face').textContent.trim();

                    if (val1 === val2) {
                        matchedPairs++;
                        selectedCards = [];
                        currentMove = 0;

                        if (matchedPairs === totalPairs) {
                            const finalScore = calculateScore();
                            document.querySelector('#score').textContent = 'Puntaje: ' + finalScore;

                            // Deshabilitar clicks después de ganar
                            cards.forEach(card => card.removeEventListener('click', activate));

                            // Enviar puntaje al servidor (usuario ya logueado en sesión)
                            fetch('guardarPuntaje.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({
                                    id_juego: 1,   // ID del juego Memory
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

                            setTimeout(() => {
                                alert('🎉 ¡Ganaste! Tu puntaje final es: ' + finalScore);
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

    // Crear las cartas
    for (let i = 0; i < totalCards; i++) {
        const div = document.createElement('div');
        div.innerHTML = cardTemplate;

        const card = div.firstChild;
        card.querySelector('.face').innerHTML = values[i];

        card.addEventListener('click', activate);
        cards.push(card);
        document.querySelector('#game').appendChild(card);
    }
});