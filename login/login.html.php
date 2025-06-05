<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: ../index/index.html.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <form action="php/auth.php" method="POST">
        <div class="header">
            <h1>Iniciar Sesión</h1>
            <div class="iconUser" style="width: 40%;"></div>
        </div>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required autofocus>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <?php
        if (isset($_GET['error'])) {
            echo "<p style='color:red;'>Usuario o contraseña incorrectos.</p>";
        }
        ?>
        <button type="submit">Iniciar Sesión <a href="../index/index.html"></a></button>
        <p class="registro" style="width: fit-content; align-self: center;">¿No tienes una cuenta? <a href="../signup/signup.html.php">Regístrate aquí</a></p>
    </form>
    <div class="bienvenida">
        <div class="quote">¡Hola de nuevo! Soy <b>ZAPPY</b>. Inicia sesión para jugar</div>
        <div class="zappyContainer">
            <h2>ZAPPY</h2>
            <img src="../img/ZappyConCara.png" alt="Imagen de zappy" class="zappyTV" style="width: 25vw;">
        </div>
    </div>
</body>

</html>