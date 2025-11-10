<?php
session_start();

// Verificar si el usuario inició sesión
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['nom_real'])) {
    header("Location: ../login/login.html.php");
    exit;
}

// Obtener ranking
require_once "../../persistencia/BaseDatos.php";
$bd = new BaseDatos();
$topUsuarios = $bd->obtenerTopUsuarios(50); // Top 50 usuarios
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/modoOscuro.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=keyboard_arrow_down" />
    <link href="https://fonts.cdnfonts.com/css/cutta" rel="stylesheet">
    <!--LLamada a la librería de iconos de Google Fonts-->
</head>

<body>
    <div class="div-row fixed-title">
        <a href="../index/indexGame.html.php"><h1>ZAPPY</h1></a>
        <div class="separador-vertical"></div>
        <h2>RANKING</h2>
    </div>
    <section class="puestos">
        <table>
            <tbody>
                <tr>
                    <td id="puesto2">2</td>
                    <td id="puesto1">1</td>
                    <td id="puesto3">3</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><?php echo isset($topUsuarios[1]) ? htmlspecialchars($topUsuarios[1]['nom_usr']) : 'Usuario 2'; ?></td>
                    <td><?php echo isset($topUsuarios[0]) ? htmlspecialchars($topUsuarios[0]['nom_usr']) : 'Usuario 1'; ?></td>
                    <td><?php echo isset($topUsuarios[2]) ? htmlspecialchars($topUsuarios[2]['nom_usr']) : 'Usuario 3'; ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="upAndDown">
            <h4 class="glowBlanco">Scroll para ver</h4>
            <span class="material-symbols-outlined">keyboard_arrow_down</span>
        </div>
        <!-- span sirve normalmente para mostrar contenido "inutil" o de adorno -->
    </section>

    <section class="rankingAll">
        <?php
        $posicion = 1;
        foreach ($topUsuarios as $usuarioRanking) {
            echo '<div class="box boxTurquesa glowTurquesa div-row align content" id="boxRanking">';
            echo '<div class="derecha">';
            echo '<img src="../../img/ZappyConCara.png" alt="" id="perfilUsr">';
            echo '<h3 id="puestoUsr">' . $posicion . '</h3>';
            echo '<p id="nombreUsr">' . htmlspecialchars($usuarioRanking['nom_usr']) . '</p>';
            echo '</div>';
            echo '<p id="puntajeUsr">' . htmlspecialchars($usuarioRanking['totalPuntos']) . '</p>';
            echo '</div>';
            $posicion++;
        }
        ?>
    </section>
    <script src="../../js/theme.js"></script>
    <script src="js/logica.js"></script>
</body>

</html>
