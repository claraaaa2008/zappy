<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es"> <!-- Indica que el contenido está en español -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Zappy</title>
    <link rel="website icon" href="../../img/ZappyConCara.png">
    <link rel="stylesheet" href="css/estilos.css?v=<?= time() ?>">
</head>

<body>
    <!-- Contenedor principal de la pantalla -->
    <div class="pantalla">
        <div class="pantalla__contenido">
            <h1>ZAPPY</h1>

            <!-- Ojos decorativos -->
            <div class="ojos">
                <div class="ojo"></div>
                <div class="ojo"></div>
            </div>
        </div>
    </div>

    <!-- Contenedor de botones -->
    <div class="botonesContainer">

        <!-- Botón de usuario (login o nombre) -->
        <a href="<?php echo isset($_SESSION['usuario']) ? '../opcionesCuenta/opcionesCuenta.html.php' : '../login/login.html.php'; ?>" style="text-decoration: none;">
            <div class="usuario">
                <img src="../../img/login/loginUser.png">
                <h2>
                    <?php
                    if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['nombre_usuario'])) {
                        echo htmlspecialchars($_SESSION['usuario']['nombre_usuario']);
                    } else {
                        echo "Iniciar Sesión";
                    }
                    ?>
                </h2>
            </div>
        </a>

        <!-- Botones de juegos -->
        <div class="botones">
            <button class="juego">
                <a href="../../juegos/juegoPiedraPapelTijera/piedraPapelTijera.html">
                    <span>Piedra papel o tijera</span>
                </a>
            </button>

            <button class="juego">
                <a href="../../juegos/memory/memory.html">
                    <span>Memory</span>
                </a>
            </button>

            <button class="juego" onclick="abrir()">
                <span>Trivia</span>
            </button>

            <!-- Modal de trivia -->
            <div id="modal01" class="modal">
                <div class="modal-contenido">
                    <h3 class="tituloModal">Elija un tipo de trivia</h3>
                    <div class="opcionesTrivia">
                        <a class="opcionTrivia" href="../../juegos/trivias/TriviaMates/triviaMates.html">Matemática</a>
                        <a class="opcionTrivia" href="../../juegos/trivias/TriviaHTML/triviaHTML.html.php">HTML</a>
                        <button class="cerrarBoton" onclick="volver()">← Volver</button>
                    </div>
                </div>
            </div>

            <button class="juego">
                <a href="../../juegos/juegoPuertas/juegoPuertas.html">
                    <span>Adivina la puerta</span>
                </a>
            </button>

            <button class="juego">
                <a href="../../juegos/juegoMosqueta/juegoMosqueta.html">
                    <span>Juego de la mosqueta</span>
                </a>
            </button>

            <!-- Botón de configuración -->
            <a href="../opcionesCuenta/opcionesCuenta.html.php" style="color: inherit; text-decoration: none; width: 100%;">
                <button class="juego opcionesCuenta">Configuración</button>
            </a>
        </div>
    </div>

    <!-- Lógica JS -->
    <script src="js/logica.js"></script>
</body>
</html>
