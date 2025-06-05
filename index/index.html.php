<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Zappy</title>
    <link rel="website icon" href="../img/ZappyConCara.png">
    </link>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="pantalla">
        <div class="pantalla__contenido">
            <h1>ZAPPY</h1>
            <div class="ojos">
                <div class="ojo"></div>
                <div class="ojo"></div>
            </div>
        </div>
    </div>
    <div class="botonesContainer">
        
        <a href="../login/login.html.php" style="text-decoration: none;">
            <div class="usuario">
                <img src="../img/login/loginUser.png"></img>
                <h2>
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        echo $_SESSION['usuario'];
                    } else {
                        echo "Iniciar Sesión";
                    }
                    ?>
                </h2>
            </div>
        </a>
        <div class="botones">

            <button class="juego">
                <span>Piedra papel o tijera</span>
                <img src="../img/piedraPapelTijera/ZappyConPiedra.png" class="iconoJuego">
            </button>

            <button class="juego">
                <span>Memory</span>
                <img src="../img/memory/CartaZappy2.png" class="iconoJuego">
            </button>

            <button class="juego" onclick="abrir()">
                <span>Trivia</span>
                <img src="../img/memory/CartaZappy2.png" class="iconoJuego">
            </button>
            <div id="modal01" class="modal">
                <div class="modal-contenido">
                    <h3 class="tituloModal">Elija un tipo de trivia</h3>
                    <div class="opcionesTrivia">
                        <!-- Cuando se haga hover, que se muestre una imagen dentro del div de cada opción-->
                        <a href=""><button class="opcionTrivia">Matemática</button></a>
                        <a href=""><button class="opcionTrivia">Cultura General</button></a>
                        <button class="cerrarBoton" onclick="volver()">← Volver</button>
                    </div>
                </div>
            </div>

            <button class="juego">
                <span>Adivina la puerta</span>
                <img src="../img/memory/CartaZappy2.png" class="iconoJuego">
            </button>
            <button class="juego">
                <span>Juego de la mosqueta</span>
                <img src="../img/memory/CartaZappy2.png" class="iconoJuego">
            </button>

            <!-- Cuando se loguee, al tocar el icono de usuario, pasa a la página de Configuración-->
            <button class="opcionesCuenta"><a href="" style="color: inherit; text-decoration: none;">Configuración</a></button>
        </div>
    </div>
</body>

</html>
<script src="js/logica.js"></script>