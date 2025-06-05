<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <aside>
        <a href="opcionesCuenta.html">Opciones de Cuenta</a></li>
    </aside>

    <section>
        <div class="screen-content">
            <h1>Configuración</h1>
            <h2>Opciones de Cuenta</h2>

            <article class="opciones-cuenta">
                <p>En esta sección puedes gestionar las opciones de tu cuenta.</p>
                <hr style="width: 100%; border: none; border-top: 1px solid #4ad9d9; margin: 10px 0;">
                
                <!------------------------------------------------>
                <form class="cambiar" action="php/cambiarUsuario.php" method="post">
                    <h3>Cambiar Usuario</h3>
                    <label for="usuario">Nuevo usuario</label>
                    <input type="text">
                    <button type="submit">Cambiar Usuario</button>
                </form>

                <hr style="width: 100%; border: none; border-top: 1px solid #4ad9d9; margin: 10px 0;">
                
                <!------------------------------------------------>
                <form class="cambiar" action="php/cambiarConf.php" method="post">
                    <h3>Cambiar Contraseña</h3>
                    <label for="contrasena">Contraseña actual</label>
                    <input type="password" name="contrasena" id="contrasena"
                    placeholder="Introduce tu contraseña actual">
                    <label for="nuevaContrasena">Nueva contraseña</label>
                    <input type="password" name="nuevaContrasena" id="nuevaContrasena"
                    placeholder="Introduce tu nueva contraseña">
                    <label for="confirmarContrasena">Confirmar nueva contraseña</label>
                    <input type="password" name="confirmarContrasena" id="confirmarContrasena"
                    placeholder="Confirma tu nueva contraseña">
                    <button type="submit">Cambiar Contraseña</button>
                </form>
                
                <hr style="width: 100%; border: none; border-top: 1px solid #d94a4a; margin: 10px 0;">
                
                <!------------------------------------------------>
                <form class="eliminar" action="php/eliminarCuenta.php" method="post">
                    <button type="submit" class="eliminarBtn">Eliminar Cuenta</button>
                </form>

            </article>
        </div>
    </section>
</body>

</html>