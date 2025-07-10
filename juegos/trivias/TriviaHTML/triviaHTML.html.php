<?php

/************************* TRAER LA BD DE LA TRIVIA *************************/
require_once("./persistenciaTrivia/BaseDatos.php");
$traerBD = new BaseDatos();

// Se obtienen todas las preguntas junto con sus opciones de respuesta desde la base de datos.
$preguntas = $traerBD->traerPreguntasConRespuestas();

// Se obtienen las respuestas correctas de cada pregunta desde la base de datos.
$respuestasCorrectas = $traerBD->respuestasCorrectas();


/************************* VARIABLES PARA EL PUNTAJE ************************/
// Inicializa la variable de puntaje del usuario.
$puntos = 0;

// Calcula el total de preguntas (usando la cantidad de respuestas correctas).
$total = count($respuestasCorrectas);


/********************* LÓGICA DE NAVEGACIÓN Y RESPUESTAS ********************/
// Determina el índice de la pregunta actual a mostrar. Si no se ha enviado nada, comienza en 0.
$preguntaActual = isset($_POST['preguntaActual']) ? intval($_POST['preguntaActual']) : 0;

// Array para almacenar las respuestas seleccionadas por el usuario.
$respuestasUsuario = [];

// Recorre todas las preguntas y guarda en el array las respuestas seleccionadas por el usuario (si existen).
foreach ($preguntas as $pid => $datos) { // $pid es el id de la pregunta
    $clave = "respuesta_" . $pid; // Crea la clave para buscar en $_POST
    if (isset($_POST[$clave])) {
        $respuestasUsuario[$pid] = $_POST[$clave];
    }
}

// Lógica para navegar entre preguntas usando los botones "anterior" y "siguiente".
if (isset($_POST['anterior'])) {
    // Si se presionó "anterior", retrocede una pregunta (sin bajar de 0).
    $preguntaActual = max(0, $preguntaActual - 1);
}

if (isset($_POST['siguiente'])) {
    // Si se presionó "siguiente", avanza una pregunta (sin superar el total).
    $preguntaActual = min($total - 1, $preguntaActual + 1);
}

// Obtiene un array con las claves (IDs) de todas las preguntas.
$clavePreguntas = array_keys($preguntas);

// Obtiene el ID de la pregunta actual a mostrar.
$pidActual = $clavePreguntas[$preguntaActual];
?>

<!------------------------------------------------------------------------------->
<!------------------- HTML y PHP para mostrar el cuestionario ------------------->
<!------------------------------------------------------------------------------->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cuestionario De Html</title>
    <!--
        La sentencia de time permite que el navegador descargue el CSS actualizado.
        Esto soluciona el problema de la imposibilidad de cargar los cambios realizados
    -->
    <link rel="website icon" href="../../../img/triviaHTML/ZappyConCara.png"></link>
    <link rel="stylesheet" href="css/Estilos.css?v=<?= time() ?>">
</head>

<body>
    <!-- Contenedor del título y la imagen de Zappy -->
    <div class="tituloContainer">
        <h1 class="titulo">Cuestionario De Html</h1>
        <img src="../../../img/triviaHTML/ZappyConCara.png" alt="TV personaje" class="zappy">
        <?php
        // Si se ha enviado el formulario (POST), calcula el puntaje y muestra el resultado.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($respuestasCorrectas as $pid => $oid_correcta) {
                $clave = "respuesta_" . $pid;
                if (isset($_POST[$clave])) {
                    $claveRespuesta = $_POST[$clave];
                    if ($claveRespuesta == $oid_correcta) {
                        $puntos++;
                    }
                }
            }
        }

        // Si el usuario respondió todo correctamente, muestra un mensaje de felicitación.
        if ($puntos == $total) {
            echo "<script>
                window.alert('¡Felicitaciones! Has acertado todo ¿Desea volver a la página principal?');
                window.location.href = '../../../sitios/index/index.html.php';
            </script>";
        } else if (isset($_POST['enviar'])) {
            switch ($puntos) {
                case 1:
                    echo "<script>
                        window.alert('¡Oh! Has obtenido: $puntos punto. Se le redireccionará a Inicio');
                        window.location.href = '../../../sitios/index/index.html.php';
                    </script>";
                    break;
                default:
                    // Muestra el resultado del usuario (puntos obtenidos sobre el total).
                    echo "<script>
                    window.alert('¡Oh! Has obtenido: $puntos puntos. Se le redireccionará a Inicio');
                    window.location.href = '../../../sitios/index/index.html.php';
                    </script>";
                    break;
            }
        }
        ?>
    </div>

    <!-- Formulario principal de la trivia -->
    <form method="POST" class="quote">
        <!-- Campo oculto para mantener el índice de la pregunta actual entre envíos -->
        <input type="hidden" name="preguntaActual" value="<?= $preguntaActual ?>">
        <!-- Campos ocultos para mantener las respuestas seleccionadas por el usuario -->
        <?php foreach ($respuestasUsuario as $pid => $rid): ?>
            <input type="hidden" name="respuesta_<?= $pid ?>" value="<?= $rid ?>">
        <?php endforeach; ?>

        <!-- Sección que muestra la pregunta actual y sus opciones -->
        <div class="pregunta">
            <!-- Muestra el texto de la pregunta actual -->
            <p><?= htmlspecialchars($preguntas[$pidActual]['pregunta']) ?></p>
            <!-- Muestra cada opción de respuesta como un radio button -->
            <?php foreach ($preguntas[$pidActual]['opciones'] as $opcion): ?>
                <label class="opcion">
                    <input type="radio" name="respuesta_<?= $pidActual ?>" value="<?= $opcion['id'] ?>"
                        <?= (isset($respuestasUsuario[$pidActual]) && $respuestasUsuario[$pidActual] == $opcion['id']) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($opcion['texto']) ?>
                </label><br>
            <?php endforeach; ?>
        </div>

        <!-- Controles de navegación: anterior, siguiente y terminar -->
        <form method="POST" class="quote" id="formTrivia">
            <div style="display:flex; justify-content: space-between;">
                <?php if ($preguntaActual > 0): ?>
                    <button type="submit" name="anterior" class="botonNav" id="btnAnterior">&lt;</button>
                <?php else: ?>
                    <div style="width:2.5rem"></div>
                <?php endif; ?>

                <?php if ($preguntaActual < $total - 1): ?>
                    <button type="submit" name="siguiente" class="botonNav" id="btnSiguiente">&gt;</button>
                <?php endif; ?>

                <?php if ($preguntaActual == $total - 1): ?>
                    <button type="submit" name="enviar" class="boton" id="btnEnviar">Terminar</button>
                <?php endif; ?>
            </div>
        </form>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los radios de la pregunta actual
            const radios = document.querySelectorAll('.pregunta input[type="radio"]');
            const btnSiguiente = document.getElementById('btnSiguiente');

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Solo avanza automáticamente si existe el botón "Siguiente"
                    if (btnSiguiente) {
                        btnSiguiente.click();
                    }
                });
            });
        });
    </script>
</body>