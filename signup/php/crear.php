<?php
session_start();

// Verifica que los datos del formulario existen
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $sexo = $_POST['sexo'];

    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "zappyMenuDeJuegos");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "INSERT INTO usuario (
                nombre_usuario, contraseña, nombre, email, fecha_nacimiento, sexo
            ) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", $usuario, $contrasena, $nombre, $email, $fechaNacimiento, $sexo);
    if ($stmt->execute()) {
        // Usuario creado correctamente, guardar en sesión y redirigir
        $_SESSION['usuario'] = $usuario;
        $stmt->close();
        $conexion->close();
        header("Location: ../../index/index.html.php");
        exit();
    } else {
        // Error al crear el usuario, redirigir con error
        $stmt->close();
        $conexion->close();
        header("Location: ../signup.html.php?error=1");
        exit();
    }
} else {
    // Si no llegan datos, redirigir al signup
    header("Location: ../signup.html.php");
    exit();
}