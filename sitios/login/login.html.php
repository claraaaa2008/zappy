<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <!-- Este formulario envía los datos al archivo PHP que maneja la autenticación -->
    <form action="php/auth.php" method="POST">
        
        <!-- Sección superior del formulario con título e ícono -->
        <div class="header">
            <h1>Iniciar Sesión</h1>
            <!-- Este div puede usarse para mostrar un ícono o imagen de usuario (parece decorativo) -->
            <div class="iconUser" style="width: 40%;"></div>
        </div>

        <!-- Campo para ingresar el nombre de usuario -->
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required autofocus>

        <!-- Campo para ingresar la contraseña -->
        <label for="contrasena">Contraseña:</label>
        <input type="text" id="contrasena" name="contrasena" required>

        <!-- Si hay un error (por ejemplo, credenciales incorrectas), se muestra un mensaje -->
        <?php
        if (isset($_GET['error'])) {
            echo "<p style='color:red;'>Usuario o contraseña incorrectos.</p>";
        }
        ?>

        <!-- Botón para enviar el formulario. El enlace dentro del botón no hace nada, podría eliminarse -->
        <button type="submit">Iniciar Sesión <a href="../index/index.html.php"></a></button>

        <!-- Enlace para ir a la página de registro si el usuario no tiene cuenta -->
        <p class="registro" style="width: fit-content; align-self: center;">
            ¿No tienes una cuenta? <a href="../signup/signup.html.php">Regístrate aquí</a>
        </p>
    </form>

    <!-- Sección de bienvenida al costado o debajo del formulario -->
    <div class="bienvenida">
        <!-- Mensaje de saludo personalizado -->
        <div class="quote">¡Hola de nuevo! Soy <b>ZAPPY</b>. Inicia sesión para jugar</div>
        
        <!-- Contenedor con el nombre del personaje y su imagen -->
        <div class="zappyContainer">
            <h2>ZAPPY</h2>
            <img src="../../img/ZappyConCara.png" alt="Imagen de zappy" class="zappyTV" style="width: 25vw;">
        </div>
    </div>
</body>
</html>