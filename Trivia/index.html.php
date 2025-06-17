<?php
// Importamos la clase que gestiona la conexión y consultas a la base de datos
require_once("./persistencia/BaseDatos.php");

// Creamos una instancia de BaseDatos
$conn = new BaseDatos();

// Obtenemos todas las preguntas junto con sus opciones de respuesta
$preguntas = $conn->traerPreguntasConRespuestas();

// También traemos las respuestas correctas para cada pregunta
$respuestasCorrectas = $conn->respuestasCorrectas();

// Inicializamos los puntos y el total de preguntas
$puntos = 0;
$total = count($respuestasCorrectas);

// Si el formulario fue enviado por método POST, evaluamos las respuestas del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($respuestasCorrectas as $pid => $oid_correcta) {
        $clave = "respuesta_" . $pid; // Ej: respuesta_1, respuesta_2, etc.
        if (isset($_POST[$clave])) {
            $claveRespuesta = $_POST[$clave]; // Opción seleccionada por el usuario
            if ($claveRespuesta == $oid_correcta) {
                $puntos++; // Si la respuesta es correcta, sumamos un punto
            }
        }
    }
    // Mostramos el resultado al usuario
    echo "<h2>Resultado: $puntos / $total</h2>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuestionario De HTML</title>
  
    <link rel="stylesheet" href="css/">
</head>
<body>
    <h1 class="titulo">Cuestionario De HTML</h1>

    <!-- Formulario que envía respuestas al mismo archivo por método POST -->
    <form method="POST" class="contenedor">
        <div class="tv">
            <!-- Imagen de Zappy (o cualquier personaje de tu app) -->
            <img src="imagenes/ZappyConCara.png" alt="TV personaje" class="zappy">

            <!-- Contenedor de preguntas con estilo de globo de diálogo -->
            <div class="globo">
                <!-- Recorremos todas las preguntas -->
                <?php foreach ($preguntas as $id => $datos): ?>
                    <div class="pregunta">
                        <!-- Mostramos el texto de la pregunta -->
                        <p><?= htmlspecialchars($datos['pregunta']) ?></p>

                        <!-- Mostramos las opciones con botones de tipo radio -->
                        <?php foreach ($datos['opciones'] as $opcion): ?>
                            <label class="opcion">
                                <input type="radio" name="respuesta_<?= $id ?>" value="<?= $opcion['id'] ?>">
                                <?= htmlspecialchars($opcion['texto']) ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

                <br>
                <!-- Botón para enviar las respuestas -->
                <button type="submit" class="boton">Enviar Respuestas</button>
            </div>
        </div>
    </form>
</body>
</html>

