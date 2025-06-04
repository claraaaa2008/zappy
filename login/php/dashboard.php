<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    // Si ya hay una sesión iniciada, redirigir al index
    header("Location: index.html.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
    <h1>Hola</h1> <?php echo $_SESSION['usuario']; ?>, bienvenido al dashboard de Zappy.
    <a href="logout.php">cerrar sesion</a>
</body>