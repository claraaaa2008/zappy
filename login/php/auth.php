<?php
session_start();

// Verifica que los datos del formulario existen
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "zappyMenuDeJuegos");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta segura usando prepared statements
    $stmt = $conexion->prepare("SELECT * FROM usuario WHERE nombre_usuario = ? AND contraseña = ?");
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Usuario válido, guardar en sesión y redirigir
        $_SESSION['usuario'] = $usuario;
        $stmt->close();
        $conexion->close();
        header("Location: ../../index/index.html.php");
        exit();
    } else {
        // Usuario no válido, redirigir con error
        $stmt->close();
        $conexion->close();
        header("Location: ../login.html.php?error=1");
        exit();
    }
} else {
    // Si no llegan datos, redirigir al login
    header("Location: ../login.html.php");
    exit();
}