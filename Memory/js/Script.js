const totalCards = 24;
let cards = [];
let selectedCards = [];
let valuesUsed = [];
let currentMove = 0;
let currentAttempts = 0;
 // Activa la música si fue bloqueada por el navegador
 document.getElementById('play-music').addEventListener('click', () => {
    const music = document.getElementById('bg-music');
    music.play();
  });

let cardTemplate = '<div class="card"><div class="back"></div><div class="face"></div></div>';

function activate(e) {
    const clicked = e.currentTarget;

    if (currentMove < 2 && !clicked.classList.contains('active')) {
        clicked.classList.add('active');

        if (!selectedCards[0] || selectedCards[0] !== clicked) {
            selectedCards.push(clicked);
            currentMove++;

            if (currentMove === 2) {
                currentAttempts++;
                document.querySelector('#stats').innerHTML = currentAttempts + ' intentos';

                const val1 = selectedCards[0].querySelector('.face').innerHTML;
                const val2 = selectedCards[1].querySelector('.face').innerHTML;

                if (val1 === val2) {
                    selectedCards = [];
                    currentMove = 0;
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

function generateValue() {
    while (true) {
        let rnd = Math.floor(Math.random() * (totalCards / 2));
        let count = valuesUsed.filter(v => v === rnd).length;
        if (count < 2) {
            valuesUsed.push(rnd);
            return rnd;
        }
    }
}

for (let i = 0; i < totalCards; i++) {
    let div = document.createElement('div');
    div.innerHTML = cardTemplate;

    let card = div.firstChild;
    let value = generateValue();
    card.querySelector('.face').innerHTML = value;

    card.addEventListener('click', activate);
    cards.push(card);
    document.querySelector('#game').appendChild(card);
}