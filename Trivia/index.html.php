<?php
require_once("./persistencia/BaseDatos.php");

$conn = new BaseDatos();
$preguntas = $conn->traerPreguntasConRespuestas();
$respuestasCorrectas = $conn->respuestasCorrectas();

$puntos = 0;
$total = count($respuestasCorrectas);

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
    echo "<h2>Resultado: $puntos / $total</h2>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Cuestionario De Html</title>
    <link rel="stylesheet" href="css/Estilos.css">
</head>

<body>
    <h1 class="titulo">Cuestionario De Html</h1>

    <img src="imagenes/ZappyConCara.png" alt="TV personaje" class="zappy">
    <form method="POST" class="globo">
        <?php foreach ($preguntas as $id => $datos): ?>
            <div class="pregunta">
                <p><?= htmlspecialchars($datos['pregunta']) ?></p>
                <?php foreach ($datos['opciones'] as $opcion): ?>
                    <label class="opcion">
                        <input type="radio" name="respuesta_<?= $id ?>" value="<?= $opcion['id'] ?>">
                        <?= htmlspecialchars($opcion['texto']) ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <br>
        <button type="submit" class="boton">Enviar Respuestas</button>
    </form>
</body>

</html>