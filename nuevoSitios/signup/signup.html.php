<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regístrate</title>
    <link rel="stylesheet" href="../login/css/estilos.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <form action="php/crear.php" method="POST">
        <div class="header">
            <h1>Regístrate</h1>
            <div class="iconUser" style="width: 40%;"></div>
        </div>

        <div class="usuarioDatos">
            <div class="dato">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" placeholder="Ej. usuario123" required autofocus>
            </div>

            <div class="dato">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required placeholder="Mínimo 8 caracteres" minlength="8">
            </div>
        </div>

        <div class="usuarioDatos">
            <div class="dato">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ej. Martin" required>
            </div>

            <div class="dato">
                <label for="sexo">Sexo</label>
                <select id="sexo" class="sexo" name="sexo" required>
                    <option value="" disabled selected>Seleccionar</option>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                    <option value="prefiero_no_decirlo">Prefiero no decirlo</option>
                </select>
            </div>
        </div>

        <div class="usuarioDatos">
            <div class="dato">
                <label for="fechaNacimiento">¿Cuándo naciste?</label>
                <input type="date" id="fechaNacimiento" class="fechaNac" name="fechaNacimiento" required>
            </div>
    
            <div class="dato">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="usuario@gmail.com" required>
            </div>
        </div>

        <button type="submit">Crear cuenta</button>

        <p class="registro" style="width: fit-content; align-self: center;">
            ¿Ya tienes una cuenta? <a href="../login/login.html.php">Inicia sesión aquí</a>
        </p>
    </form>

    <div class="bienvenida">
        <div class="quote">¡Bienvenido! Soy <b>ZAPPY</b>.<br> Crea una cuenta para que podamos jugar juntos</div>
        <div class="zappyContainer">
            <h2>ZAPPY</h2>
            <img src="../../img/ZappyConCara.png" alt="Imagen de zappy" class="zappyTV" style="width: 25vw;">
        </div>
    </div>
</body>

</html>
