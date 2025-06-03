<?php
session_start();

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "zappyMenuDeJuegos");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener datos del formulario
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Consulta para validar usuario
$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$usuario' AND contraseña = '$contrasena'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    // Usuario válido
    $conexion->close();
    header("Location: ../../index.html");
    exit();
} else {
    // Usuario no válido, guardar mensaje en sesión y redirigir al login
    $_SESSION['error'] = "Usuario o contraseña incorrectos.";
    $conexion->close();
    header("Location: ../login.html");
    exit();
}