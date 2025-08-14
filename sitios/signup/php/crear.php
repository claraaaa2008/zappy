<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $sexo = $_POST['sexo'];

    $conexion = new mysqli("localhost", "root", "", "zappyMenuDeJuegos");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Hashear la contraseña
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (
        nombre_usuario, contrasena, nombre, email, fecha_nacimiento, sexo
    ) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssssss", $usuario, $hash, $nombre, $email, $fechaNacimiento, $sexo);

    if ($stmt->execute()) {
        // Guardamos datos en la sesión
        $_SESSION['usuario'] = [
            'id' => $conexion->insert_id,
            'nombre_usuario' => $usuario,
            'nombre' => $nombre,
            'email' => $email,
            'permisos' => 'Jugador'
        ];

        $stmt->close();
        $conexion->close();
        header("Location: ../../index/index.html.php");
        exit();
    } else {
        $stmt->close();
        $conexion->close();
        header("Location: ../../signup/signup.html.php?error=1");
        exit();
    }
} else {
    header("Location: ../signup.html.php");
    exit();
}
