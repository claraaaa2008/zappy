<?php
session_start();

// Verificar si el usuario inició sesión
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['nom_real'])) {
    header("Location: ../login/login.html.php");
    exit;
}
// Guardar datos básicos
$usuario = $_SESSION['usuario'];
$nombreReal = $usuario['nom_real'];
$nombreUsuario = $usuario['nom_usr'];
$idGrupo = $usuario['idGrupo'];
$idUsr = $usuario['idUsr']; // 👈 asegurate que exista en la sesión

// ==============================
// Conexión a la base de datos
// ==============================
$conexion = new mysqli("localhost", "root", "", "zappymenu");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Traer fecha de nacimiento del usuario
$sql = "SELECT fecha_nac FROM Usuario WHERE idUsr = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsr);
$stmt->execute();
$resultado = $stmt->get_result();
$fechaNac = null;
if ($fila = $resultado->fetch_assoc()) {
    $fechaNac = $fila['fecha_nac'];
}

// Calcular edad
$edad = null;
if ($fechaNac) {
    $fechaNacimiento = new DateTime($fechaNac);
    $hoy = new DateTime();
    $edad = $hoy->diff($fechaNacimiento)->y;
}

$stmt->close();
$conexion->close();

// ==============================
// Obtener puntaje total y ranking
// ==============================
require_once "../../persistencia/BaseDatos.php";
$bd = new BaseDatos();
$puntajeTotal = $bd->obtenerPuntajeTotalUsuario($idUsr);
$rankingUsuario = $bd->obtenerRankingUsuario($idUsr);
$topUsuarios = $bd->obtenerTopUsuarios(10);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Zappy</title>
    <link rel="website icon" href="../../img/ZappyConCara.png">
    <link rel="stylesheet" href="css/transicion.css">
    <link rel="stylesheet" href="../../css/modoOscuro.css">
    <link rel="stylesheet" href="css/estilosMain1.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
    <link href="https://fonts.cdnfonts.com/css/cutta" rel="stylesheet">
</head>

<body class="div-column">
    <header class="div-row">
        <div class="div-row">
            <?php
            $fotoPerfil = isset($usuario['fotoPerfil']) && $usuario['fotoPerfil'] !== ""
                ? "../../img/perfiles/" . htmlspecialchars($usuario['fotoPerfil'])
                : "../../img/perfiles/default.png"; // imagen por defecto
            ?>
            <div class="circulo">
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil" class="circle-img">
            </div>
            <p><?php echo htmlspecialchars($nombreReal); ?></p>
        </div>
        <a href="index.html.php">
            <h1>ZAPPY</h1>
        </a>
        <div class="div-row">
            <a href="#miInfo" onclick="abrirModal('miInfo', event)" class="btn"><span class="material-symbols-rounded">person</span></a>
            <a href="../grupos/grupos.html.php" class="btn"><span class="material-symbols-rounded">group</span></a>
            <a href="../ranking/ranking.html.php" class="btn"><span class="material-symbols-rounded">leaderboard</span></a>
            <a href="../ajustes/ajustes.html.php" class="btn"><span class="material-symbols-rounded">settings</span></a>
            <a href="#logout" onclick="abrirModal('logout', event)" class="logout"><span class="material-symbols-rounded">logout</span></a>
        </div>
    </header>

    <section class="div-row" style="align-items: flex-start;">
        <aside>
            <h2>Ranking</h2>
            <div class="div-column">
                <?php
                $posicion = 1;
                foreach ($topUsuarios as $usuarioRanking) {
                    echo '<div class="div-row">';
                    echo '<p><b>' . $posicion . '.</b> ' . htmlspecialchars($usuarioRanking['nom_usr']) . '</p>';
                    echo '<p class="puntaje">' . htmlspecialchars($usuarioRanking['totalPuntos']) . '</p>';
                    echo '</div>';
                    $posicion++;
                }
                ?>
            </div>
        </aside>

        <main>
            <a href="../../juegos/memory/memory.html">
                <div class="box boxAmarillo glowAmarillo">Memory</div>
            </a>
            <a href="../../juegos/juegoPiedraPapelTijera/piedraPapelTIjera.html">
                <div class="box boxAmarillo glowAmarillo">Piedra Papel o Tijera</div>
            </a>
            <a href="../../juegos/trivias/TriviaMates/triviaMates.html">
                <div class="box boxAmarillo glowAmarillo">Trivia Matemática</div>
            </a>
            <a href="../../juegos/trivias/TriviaHTML/triviaHTML.html.php">
                <div class="box boxAmarillo glowAmarillo">Trivia HTML</div>
            </a>
            <a href="../../juegos/juegoMosqueta/juegoMosqueta.html">
                <div class="box boxAmarillo glowAmarillo">Juego de la Mosqueta</div>
            </a>
            <a href="../../juegos/juegoPuertas/juegoPuertas.html">
                <div class="box boxAmarillo glowAmarillo">Monty Hall</div>
            </a>
        </main>
    </section>






    <!--------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------->
    <div class="modal" id="miInfo">
        <div class="container">
            <div class="box boxTurquesa div-column">
                <div class="div-row align content">
                    <div class="div-row profile">
                        <!-- Círculo pequeño -->
                        <div class="circulito">
                           <img src="<?php echo "../../img/perfiles/" . htmlspecialchars($fotoPerfil); ?>" alt="Foto de perfil" class="circle-img">
                        </div>

                        <div class="div-column">
                            <h3><?php echo htmlspecialchars($nombreReal); ?></h3>
                            <h6>@<?php echo htmlspecialchars($nombreUsuario); ?></h6>
                        </div>
                    </div>
                    <p class="puntaje"><?php echo htmlspecialchars($puntajeTotal); ?></p>
                </div>

                <div class="div-row">
                    <p>Edad</p>
                    <p class="atributoField div-row">
                        <?php echo htmlspecialchars($edad ?? 'Sin datos'); ?>
                    </p>
                </div>
                <div class="div-row">
                    <p>Cumpleaños</p>
                    <p class="atributoField div-row">
                        <?php echo $fechaNac ? date('d/m/Y', strtotime($fechaNac)) : 'Sin datos'; ?>
                    </p>
                </div>


                <div class="div-column innerBox">
                    <h3>Juego</h3>

                    <div class="div-row">
                        <p>Mi grupo</p>
                        <p class="atributoField div-row">ID Grupo: <?php echo htmlspecialchars($idGrupo); ?></p>
                    </div>
                    <div class="div-row">
                        <p>Ranking</p>
                        <p class="atributoField div-row"><?php echo htmlspecialchars($rankingUsuario); ?></p>
                    </div>
                </div>
                <p style="font-size: x-small; text-align: center;">Presione en cualquier lado fuera del modal para
                    cerrar</p>
            </div>
        </div>
    </div>


    <!--------------------------------------------------------------------------->
    <div class="modal" id="logout">
        <div class="container">
            <div class="box boxTurquesa div-column">
                <p>¿Estás seguro de que deseas <br><b>Cerrar Sesión</b>?</p>
                <div class="div-row align content">
                    <!-- ✅ Este formulario envía al logout.php -->
                    <form action="../login/php/logout.php" method="post">
                        <button type="submit" class="buttonRojo">Aceptar</button>
                    </form>
                    <!-- ❌ Este solo cierra el modal -->
                    <button type="button" class="buttonTurquesa" onclick="cerrarModal('logout')">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="js/logica.js"></script>
<script src="../../js/theme.js"></script>

</html>
