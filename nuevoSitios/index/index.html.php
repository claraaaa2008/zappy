<?php
session_start();

// Verificar si el usuario inició sesión
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['nom_real'])) {
    header("Location: ../login/login.html.php");
    exit;
}

// Guardar los datos de sesión en variables
$nombreReal = $_SESSION['usuario']['nom_real'];
$nombreUsuario = $_SESSION['usuario']['nom_usr'];
$idGrupo = $_SESSION['usuario']['idGrupo'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zappy - Inicio</title>
    <link rel="icon" href="../../img/ZappyConCara.png">
    <link rel="stylesheet" href="../css/modoOscuro.css">
    <link rel="stylesheet" href="css/estilosCover.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
</head>

<body class="div-row">
    <!-- Panel izquierdo con ZAPPY -->
    <div class="box boxTurquesa div-column">
        <h1>ZAPPY</h1>
        <div class="ojos">
            <div class="ojo"></div>
            <div class="ojo"></div>
        </div>
        <a href="../juegos/indexGame.html"><button class="buttonGris">Click para jugar</button></a>
    </div>

    <!-- Panel derecho con opciones -->
    <div class="div-column align listaBotones">
        <div class="div-column perfil">
            <a href="#miInfo" onclick="abrirModal('miInfo', event)">
                <div class="circulo"></div>
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
            <a href="../ranking/ranking.html.php">
                <button type="button" class="buttonAmarillo">
                    <span class="material-symbols-rounded">leaderboard</span>
                    Ranking
                </button>
            </a>
            <a href="../configuracion/configuracion.html.php">
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

    <!-- MODAL: Información del usuario -->
    <div class="modal" id="miInfo">
        <div class="container">
            <div class="box boxTurquesa div-column">
                <div class="div-row align content">
                    <div class="div-row profile">
                        <div class="circulito"></div>
                        <div class="div-column">
                            <h3><?php echo htmlspecialchars($nombreReal); ?></h3>
                            <p>@<?php echo htmlspecialchars($nombreUsuario); ?></p>
                        </div>
                    </div>
                    <p>ID Grupo: <?php echo htmlspecialchars($idGrupo); ?></p>
                </div>
                <button onclick="cerrarModal('miInfo')" class="buttonGris">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- MODAL: Cerrar sesión -->
    <div class="modal" id="logout">
        <div class="container">
            <div class="box boxTurquesa div-column align">
                <h3>¿Seguro que deseas cerrar sesión?</h3>
                <div class="div-row" style="gap: 10px;">
                    <a href="../login/php/logout.php"><button class="buttonAmarillo">Sí, salir</button></a>
                    <button onclick="cerrarModal('logout')" class="buttonGris">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function abrirModal(id, event) {
            event.preventDefault();
            document.getElementById(id).style.display = "flex";
        }
        function cerrarModal(id) {
            document.getElementById(id).style.display = "none";
        }
    </script>
</body>
</html>
