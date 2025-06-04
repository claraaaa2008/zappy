<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Document</title>
</head>

<body>
    <h1>iniciar sesión</h1>
    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>Usuario o contraseña incorrectos.</p>";
    }
    ?>
    <form action="auth.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <br>
        <button type="submit">Entrar</button>
    </form>
</body>

</html>