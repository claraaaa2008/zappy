<?php
session_start();

// Validar si los campos existen
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Conectar a la base de datos
    $conexion = new mysqli("localhost", "root", "", "zappyMenuDeJuegos");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Buscar el usuario
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ? AND contrasena = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Si el usuario existe
    if ($resultado->num_rows === 1) {
        $_SESSION['usuario'] = $usuario;
        header("Location: ../../index/index.html.php");  // Redirige al menú
        exit();
    } else {
        // Usuario o contraseña incorrectos
        header("Location: ../login.html.php?error=1");
        exit();
    }
} else {
    // Si no llegan los datos, redirigir al login
    header("Location: ../login.html.php");
    exit();
}

