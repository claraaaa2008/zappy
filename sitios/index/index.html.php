<!DOCTYPE html>
<html lang="es"> <!-- Indica que el contenido está en español -->

<head>
    <meta charset="UTF-8"> <!-- Configura la codificación de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que la página sea responsive -->
    <title>Inicio - Zappy</title> <!-- Título de la pestaña del navegador -->

    <!-- Ícono de la página que aparece en la pestaña del navegador -->
    <link rel="website icon" href="../img/ZappyConCara.png">
    </link>

    <!-- Enlace al archivo de estilos CSS con un parámetro dinámico para evitar que el navegador use una versión en caché -->
    <link rel="stylesheet" href="css/estilos.css?v=<?= time() ?>">
    <!--
        time() va a permitir descargar el archivo estilos.css cada vez que se refresque la página,
        lo cual asegura que se apliquen los cambios realizados
    -->
</head>

<body>
    <!-- Contenedor principal de la pantalla -->
    <div class="pantalla">
        <div class="pantalla__contenido">
            <h1>ZAPPY</h1> <!-- Título principal -->

            <!-- Contenedor para los "ojos" decorativos -->
            <div class="ojos">
                <div class="ojo"></div> <!-- Ojo izquierdo -->
                <div class="ojo"></div> <!-- Ojo derecho -->
            </div>
        </div>
    </div>

    <!-- Contenedor de botones de la interfaz principal -->
    <div class="botonesContainer">

        <!-- Botón de usuario / login, que cambia según si el usuario está logueado -->
        <a href="../login/login.html.php" style="text-decoration: none;">
            <div class="usuario">
                <img src="../img/login/loginUser.png"></img> <!-- Imagen del icono de usuario -->
                <h2>
                    <?php
                    // Si el usuario está logueado, se muestra su nombre, si no, se muestra "Iniciar Sesión"
                    if (isset($_SESSION['usuario'])) {
                        echo $_SESSION['usuario'];
                    } else {
                        echo "Iniciar Sesión";
                    }
                    ?>
                </h2>
            </div>
        </a>

        <!-- Contenedor de los botones de juegos -->
        <div class="botones">
            <!-- Botón para el juego "Piedra, papel o tijera" -->
            <button class="juego">
                <a href="../juegoPiedraPapelTijera/piedraPapelaTijera.html">
                    <span>Piedra papel o tijera</span>
                </a>
            </button>

            <!-- Botón para el juego "Memory" -->
            <button class="juego">
                <a href="../Memory/memory.html">
                    <span>Memory</span>
                </a>
            </button>

            <!-- Botón para abrir la ventana modal de selección de trivia -->
            <button class="juego" onclick="abrir()">
                <span>Trivia</span>
            </button>
            <!-- Modal con opciones de trivia -->
            <div id="modal01" class="modal">
                <div class="modal-contenido">
                    <h3 class="tituloModal">Elija un tipo de trivia</h3>
                    <div class="opcionesTrivia">
                        <!-- Opciones de trivia con enlaces -->
                        <a class="opcionTrivia" href="../trivias/TriviaMates/triviaMates.html">Matemática</a>
                        <a class="opcionTrivia" href="../trivias/TriviaHTML/triviaHTML.html.php">HTML</a>

                        <!-- Botón para cerrar el modal y volver al menú -->
                        <button class="cerrarBoton" onclick="volver()">← Volver</button>
                    </div>
                </div>
            </div>

            <!-- Botón para el juego "Adivina la puerta" -->
            <button class="juego">
                <a href="../juegoPuertas/juegoPuertas.html">
                    <span>Adivina la puerta</span>
                </a>
            </button>

            <!-- Botón para el juego "Juego de la mosqueta" -->
            <button class="juego">
                <a href="../juegoMosqueta/juegoMosqueta.html">
                    <span>Juego de la mosqueta</span>
                </a>
            </button>

            <!-- Botón de configuración que lleva a las opciones de cuenta -->
            <a href="../opcionesCuenta/opcionesCuenta.html.php" style="color: inherit; text-decoration: none; width: 100%;">
                <button class="juego opcionesCuenta">Configuración</button>
            </a>
        </div>
    </div>
</body>

</html>

<!-- Enlace al archivo JavaScript con la lógica de interacciones -->
<script src="js/logica.js"></script>