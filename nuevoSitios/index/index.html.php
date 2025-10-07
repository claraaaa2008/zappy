<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Zappy</title>
    <link rel="website icon" href="../../img/ZappyConCara.png">
    <link rel="stylesheet" href="../css/modoOscuro.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/estilos.css?v=<?= time() ?>">
</head>

<body class="div-row align">
    <!-- Contenedor principal de la pantalla -->
    <div class="box pantalla contenedorLlenar">
        <div class="div-column">
            <h1 class="titulo">ZAPPY</h1>

            <!-- Ojos decorativos -->
            <div class="ojos">
                <div class="ojo"></div>
                <div class="ojo"></div>
            </div>
        </div>
    </div>

    <!-- Contenedor de botones -->
    <div class="div-column contenedorLlenar">

        <!-- Botón de usuario (login o nombre) -->
        <a href="<?php echo isset($_SESSION['usuario']) ? '../opcionesCuenta/opcionesCuenta.html.php' : '../login/login.html.php'; ?>" style="text-decoration: none;">
            <div class="usuario">
                <img src="../../img/login/loginUser.png">
                <h2>
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        // Mostrar nombre real
                        echo htmlspecialchars($_SESSION['usuario']['nom_real']);
                        // Si querés mostrar el nombre de usuario en vez del real, usa:
                        // echo htmlspecialchars($_SESSION['usuario']['nom_usr']);
                    } else {
                        echo "Iniciar Sesión";
                    }
                    ?>
                </h2>
            </div>
        </a>

        <!-- Botones de juegos -->
        <div class="div-column">
            <a href="">
                <button class="buttonAmarillo">Usuario</button>
            </a>
            <a href="">
                <button class="buttonAmarillo">Grupos</button>
            </a>
            <a href="">
                <button class="buttonAmarillo">Ranking</button>
            </a>
            <a href="">
                <button class="buttonAmarillo">Ajustes</button>
            </a>
            <a href="">
                <button class="buttonAmarillo">Cerrar Sesión</button>
            </a>
        </div>
    </div>

    <!-- Lógica JS -->
    <script src="js/logica.js"></script>
</body>
</html>