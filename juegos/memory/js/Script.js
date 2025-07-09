const totalCards = 24; // Total de cartas que habrá en el juego (12 pares)
let cards = []; // Array para guardar los elementos de las cartas creadas
let selectedCards = []; // Array para guardar las cartas que el jugador ha seleccionado (máximo 2)
let valuesUsed = []; // Array para controlar cuántas veces se ha usado cada valor (para pares)
let currentMove = 0; // Contador de cartas seleccionadas en el movimiento actual (máximo 2)
let currentAttempts = 0; // Contador de intentos realizados por el jugador

// Activar la música cuando el usuario haga click en el botón con id 'play-music' (para evitar bloqueo automático por navegador)
document.getElementById('play-music').addEventListener('click', () => {
    const music = document.getElementById('bg-music'); // Obtenemos el elemento audio
    music.play(); // Reproducimos la música
});

// Plantilla HTML para cada carta, con dos caras: una "back" (trasera) y otra "face" (frontal)
let cardTemplate = '<div class="card"><div class="back"></div><div class="face"></div></div>';

// Función que se ejecuta cuando se hace click en una carta
function activate(e) {
    const clicked = e.currentTarget; // Carta que fue clickeada

    // Solo permitir seleccionar 2 cartas a la vez y que la carta clickeada no esté ya activa
    if (currentMove < 2 && !clicked.classList.contains('active')) {
        clicked.classList.add('active'); // Mostrar la carta (darle clase activa)

        // Si no hay cartas seleccionadas o la carta clickeada no es la misma que la primera seleccionada
        if (!selectedCards[0] || selectedCards[0] !== clicked) {
            selectedCards.push(clicked); // Añadir la carta seleccionada al array
            currentMove++; // Incrementar el número de cartas seleccionadas en este turno

            // Cuando ya se seleccionaron dos cartas
            if (currentMove === 2) {
                currentAttempts++; // Incrementar contador de intentos
                document.querySelector('#stats').innerHTML = currentAttempts + ' intentos'; // Mostrar intentos

                // Obtener los valores (contenido) de las dos cartas seleccionadas
                const val1 = selectedCards[0].querySelector('.face').innerHTML;
                const val2 = selectedCards[1].querySelector('.face').innerHTML;

                // Comparar si los valores son iguales (se encontró un par)
                if (val1 === val2) {
                    selectedCards = []; // Limpiar cartas seleccionadas para siguiente turno
                    currentMove = 0;    // Reiniciar contador de cartas seleccionadas
                } else {
                    // Si no coinciden, ocultar las cartas después de 800ms y reiniciar para el siguiente intento
                    setTimeout(() => {
                        selectedCards[0].classList.remove('active'); // Volver a ocultar carta 1
                        selectedCards[1].classList.remove('active'); // Volver a ocultar carta 2
                        selectedCards = []; // Limpiar cartas seleccionadas
                        currentMove = 0;    // Reiniciar contador
                    }, 800);
                }
            }
        }
    }
}

// Función para generar valores aleatorios que se usan para asignar a las cartas (cada valor debe repetirse dos veces)
function generateValue() {
    while (true) {
        let rnd = Math.floor(Math.random() * (totalCards / 2)); // Valor aleatorio entre 0 y (totalCards/2 -1)
        // Contar cuántas veces se ha usado ese valor
        let count = valuesUsed.filter(v => v === rnd).length;
        if (count < 2) { // Si ese valor aún no se usó dos veces
            valuesUsed.push(rnd); // Agregar ese valor a la lista
            return rnd; // Retornar el valor para asignarlo a una carta
        }
    }
}

// Bucle para crear todas las cartas
for (let i = 0; i < totalCards; i++) {
    let div = document.createElement('div'); // Crear un div temporal
    div.innerHTML = cardTemplate; // Insertar el template dentro del div

    let card = div.firstChild; // Obtener el primer hijo (la carta)
    let value = generateValue(); // Generar valor para la carta (cada valor tendrá 2 cartas iguales)
    card.querySelector('.face').innerHTML = value; // Poner el valor dentro de la cara visible de la carta

    card.addEventListener('click', activate); // Agregar evento para detectar clicks en la carta
    cards.push(card); // Guardar la carta en el array de cartas
    document.querySelector('#game').appendChild(card); // Añadir la carta al contenedor con id "game"
}
