// Variable global para guardar el resultado correcto de la pregunta actual
let resultado = 0;
// Contadores de respuestas correctas e incorrectas
let contadorCorrectas = 0;
let contadorIncorrectas = 0;

/* Esta función se ejecuta cuando el usuario hace clic en "Enviar"
Compara la respuesta del usuario con el resultado correcto
Si es correcta, suma uno al contador de correctas; si no, suma uno al de incorrectas
Luego actualiza los textos en pantalla con los nuevos valores */
function respuesta() {
    let respuesta = document.getElementById("txtRespuesta").value;
    if (respuesta == resultado) {
        contadorCorrectas++;
        document.getElementById("txtRespuesta").value = "";
        document.getElementById("txtRespuesta").focus();
        document.getElementById("txtCorrectas").innerHTML = contadorCorrectas;
    } else {
        contadorIncorrectas++;
        document.getElementById("txtRespuesta").value = "";
        document.getElementById("txtRespuesta").focus();
        document.getElementById("txtIncorrectas").innerHTML = contadorIncorrectas;
    }
    // Genera una nueva pregunta según la dificultad seleccionada
    let dificultad = document.querySelector('input.botoncito:checked');
    if (dificultad) {
        switch (dificultad.value) {
            case "facil":
                preguntaFacil();
                break;
            case "medio":
                preguntaMedio();
                break;
            case "dificil":
                preguntaDificil();
                break;
        }
    } else {
        // Si no hay dificultad seleccionada, por defecto pregunta fácil
        preguntaFacil();
    }
}

/* Genera una pregunta fácil (números del 1 al 9, suma, resta o multiplicación)
Muestra la pregunta y guarda el resultado correcto */
function preguntaFacil() {
    let min = 1;
    let max = 9;
    let numero1 = Math.floor(Math.random() * (max - min + 1)) + min;
    let numero2 = Math.floor(Math.random() * (max - min + 1)) + min;

    let operacion = Math.floor(Math.random() * 3) + 1;

    let pregunta = "";

    switch (operacion) {
        case 1:
            pregunta = `¿Cuánto es ${numero1} + ${numero2}?`;
            resultado = numero1 + numero2;
            break;
        case 2:
            pregunta = `¿Cuánto es ${numero1} - ${numero2}?`;
            resultado = numero1 - numero2;
            break;
        case 3:
            pregunta = `¿Cuánto es ${numero1} * ${numero2}?`;
            resultado = numero1 * numero2;
            break;
    }
    // Muestra la pregunta en pantalla
    document.getElementById("txtPregunta").innerHTML = pregunta;
}

/* Genera una pregunta de dificultad media (números del 10 al 99)
Muestra la pregunta y guarda el resultado correcto */
function preguntaMedio() {
    let min = 10;
    let max = 99;
    let numero1 = Math.floor(Math.random() * (max - min + 1)) + min;
    let numero2 = Math.floor(Math.random() * (max - min + 1)) + min;

    let operacion = Math.floor(Math.random() * 3) + 1;
    let resultado = 0;
    let pregunta = "";

    switch (operacion) {
        case 1:
            pregunta = `¿Cuánto es ${numero1} + ${numero2}?`;
            resultado = numero1 + numero2;
            break;
        case 2:
            pregunta = `¿Cuánto es ${numero1} - ${numero2}?`;
            resultado = numero1 - numero2;
            break;
        case 3:
            pregunta = `¿Cuánto es ${numero1} * ${numero2}?`;
            resultado = numero1 * numero2;
            break;
    }
    // Muestra la pregunta en pantalla
    document.getElementById("txtPregunta").innerHTML = pregunta;
}

/* Genera una pregunta difícil (números del 100 al 999)
Muestra la pregunta y guarda el resultado correcto */
function preguntaDificil() {
    let min = 100;
    let max = 999;
    let numero1 = Math.floor(Math.random() * (max - min + 1)) + min;
    let numero2 = Math.floor(Math.random() * (max - min + 1)) + min;

    let operacion = Math.floor(Math.random() * 3) + 1;
    let resultado = 0;
    let pregunta = "";

    switch (operacion) {
        case 1:
            pregunta = `¿Cuánto es ${numero1} + ${numero2}?`;
            resultado = numero1 + numero2;
            break;
        case 2:
            pregunta = `¿Cuánto es ${numero1} - ${numero2}?`;
            resultado = numero1 - numero2;
            break;
        case 3:
            pregunta = `¿Cuánto es ${numero1} * ${numero2}?`;
            resultado = numero1 * numero2;
            break;
    }
    // Muestra la pregunta en pantalla
    document.getElementById("txtPregunta").innerHTML = pregunta;
}