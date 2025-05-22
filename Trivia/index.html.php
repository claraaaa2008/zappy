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
    <title>Trivia</title>
    <link rel="stylesheet" href="css/Estilos.css"/>
</head>
<body>
    <h1>Cuestionario de HTML</h1>
    <form method="POST">
        <img src="imagenes/ZappyConCara.png"  class="zappy">
        

<div class="tooltip">
    <?php foreach ($preguntas as $id => $datos): ?>
        <div class="pregunta">
            <h3><?= htmlspecialchars($datos['pregunta']) ?></h3>
        </div>
        <div class="opciones">
            <?php foreach ($datos['opciones'] as $opcion): ?>
                <label>
                    <input type="radio" name="respuesta_<?= $id ?>" value="<?= $opcion['id'] ?>">
                    <?= htmlspecialchars($opcion['texto']) ?>
                </label><br>
            <?php endforeach; ?>
        </div>
        <br>
    <?php endforeach; ?>
</div>

</body>
</html>
