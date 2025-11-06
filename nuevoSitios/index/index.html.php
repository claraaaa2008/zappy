<?php
session_start();
require_once "../../persistencia/BaseDatos.php"; // Asegurate de incluir tu clase BaseDatos

// Verificar si el usuario inició sesión
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['nom_real'])) {
    header("Location: ../login/login.html.php");
    exit;
}

$nombreReal = $_SESSION['usuario']['nom_real'];
$nombreUsuario = $_SESSION['usuario']['nom_usr'];
$idGrupo = $_SESSION['usuario']['idGrupo'];
$idUsr = $_SESSION['usuario']['idUsr'];

// ==============================
// Conexión con tu clase
// ==============================
$bd = new BaseDatos();

// Obtener datos del usuario (fecha y foto)
$sql = "SELECT fecha_nac, fotoPerfil FROM Usuario WHERE idUsr = ?";
$resultado = $bd->consultar($sql, "i", $idUsr);

$fechaNac = null;
$fotoPerfil = null;
if ($resultado && count($resultado) > 0) {
    $fechaNac = $resultado[0]['fecha_nac'];
    $fotoPerfil = $resultado[0]['fotoPerfil'];
}

// Asignar imagen por defecto si no hay


$edad = null;
if ($fechaNac) {
    $fechaNacimiento = new DateTime($fechaNac);
    $hoy = new DateTime();
    $edad = $hoy->diff($fechaNacimiento)->y;
}


$fotoPerfil = isset($usuario['fotoPerfil']) && $usuario['fotoPerfil'] !== ""
    ? "../img/" . htmlspecialchars($usuario['fotoPerfil'])
    : "../../img/perfiles/default.png";
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Zappy</title>
    <link rel="website icon" href="../../img/ZappyConCara.png">
    <link rel="stylesheet" href="css/transicion.css">
    <link rel="stylesheet" href="../css/modoOscuro.css">
    <link rel="stylesheet" href="css/estilosCover.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
    <link href="https://fonts.cdnfonts.com/css/cutta" rel="stylesheet">
</head>

<body class="div-row">
    <div class="box boxTurquesa div-column">
        <h1>ZAPPY</h1>
        <div class="ojos">
            <div class="ojo"></div>
            <div class="ojo"></div>
        </div>
        <button class="buttonGris" onclick="window.location.href='indexGame.html.php'">Click Para Jugar</button>
    </div>

    <div class="div-column align listaBotones">
        <div class="div-column perfil">
            <a href="#miInfo" onclick="abrirModal('miInfo', event)">

                 <?php
            $fotoPerfil = isset($usuario['fotoPerfil']) && $usuario['fotoPerfil'] !== ""
                ? "../../img/perfiles/" . htmlspecialchars($usuario['fotoPerfil'])
                : "../../img/perfiles/default.png"; // imagen por defecto
            ?>
            <div class="circulo">
                <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil" class="circle-img">
            </div>

            </a>
            <h2><?php echo htmlspecialchars($nombreReal); ?></h2>
        </div>
        <div class="div-column align botones">
            <a href="#miInfo" onclick="abrirModal('miInfo', event)">
                <button type="button" class="buttonAmarillo">
                    <span class="material-symbols-rounded">person</span>
                    Usuario
                </button>
            </a>
            <a href="../grupos/grupos.html.php">
                <button type="button" class="buttonAmarillo">
                    <span class="material-symbols-rounded">group</span>
                    Grupos
                </button>
            </a>
            <a href="../ranking/ranking.html">
                <button type="button" class="buttonAmarillo">
                    <span class="material-symbols-rounded">leaderboard</span>
                    Ranking
                </button>
            </a>
            <a href="../ajustes/ajustes.html.php">
                <button type="button" class="buttonAmarillo">
                    <span class="material-symbols-rounded">settings</span>
                    Ajustes
                </button>
            </a>
            <a href="#logout" onclick="abrirModal('logout', event)">
                <button type="button" class="buttonAmarillo" style="color: #f1385a;">
                    <span class="material-symbols-rounded">logout</span>
                    Cerrar Sesión
                </button>
            </a>
        </div>
    </div>

    <!--------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------->
    <div class="modal" id="miInfo">
        <div class="container">
            <div class="box boxTurquesa div-column">
                <div class="div-row align content">
                    <div class="div-row profile">
                       <?php
                $fotoPerfil = isset($usuario['fotoPerfil']) && $usuario['fotoPerfil'] !== ""
                    ? "../img/perfiles/" . htmlspecialchars($usuario['fotoPerfil'])
                    : "../../img/perfiles/default.png"; // imagen por defecto
                ?>

                        <!-- Círculo pequeño -->
                        <div class="circulito">
                           <img src="<?php echo $fotoPerfil; ?>" alt="Foto de perfil" class="circle-img">
                        </div>

                        <div class="div-column">
                            <h3><?php echo htmlspecialchars($nombreReal); ?></h3>
                            <h6>@<?php echo htmlspecialchars($nombreUsuario); ?></h6>
                        </div>
                    </div>
                    <p class="puntaje">xxxxx</p>
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
                        <p class="atributoField div-row">№ xx</p>
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

<script src="../js/theme.js"></script>
<script src="js/logica.js"></script>

</html>