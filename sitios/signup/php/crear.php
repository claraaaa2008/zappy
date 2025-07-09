<?php
session_start(); // Iniciamos la sesión para poder guardar datos del usuario luego

// Verificamos que se hayan enviado todos los datos requeridos desde el formulario
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    // Guardamos los datos que vienen del formulario en variables
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

    // Preparamos la consulta para insertar un nuevo usuario en la tabla
    $sql = "INSERT INTO usuario (
        nombre_usuario, contrasena, nombre, email, fecha_nacimiento, sexo
    ) VALUES (?, ?, ?, ?, ?, ?)";

    // Preparamos el statement para evitar inyecciones SQL
    $stmt = $conexion->prepare($sql);

    // Asignamos los valores que vienen del formulario a los placeholders del SQL
    $stmt->bind_param("ssssss", $usuario, $contrasena, $nombre, $email, $fechaNacimiento, $sexo);

    // Intentamos ejecutar la consulta
    if ($stmt->execute()) {
        // Si salió bien, guardamos el nombre de usuario en sesión (como si se hubiera logueado automáticamente)
        $_SESSION['usuario'] = $usuario;

        // Cerramos conexiones y redirigimos al inicio
        $stmt->close();
        $conexion->close();
        header("Location: ../../index/index.html.php");
        exit();
    } else {
        // Si hubo un error al registrar, redirigimos a signup con un mensaje de error
        $stmt->close();
        $conexion->close();
        header("Location: ../../signup/signup.html.php?error=1");
        exit();
    }
} else {
    // Si no llegan datos, redirigir al signup
    header("Location: ../signup.html.php");
    exit();
}
