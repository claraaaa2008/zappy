<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $conexion = new mysqli("localhost", "root", "", "zappyMenuDeJuegos");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta solo por el usuario
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuarioBD = $resultado->fetch_assoc();

        // Verificar contraseña con password_verify()
        if (password_verify($contrasena, $usuarioBD['contrasena'])) {
            // Guardar datos completos en sesión (como en crear.php)
            $_SESSION['usuario'] = [
                'id' => $usuarioBD['id'],
                'nombre_usuario' => $usuarioBD['nombre_usuario'],
                'nombre' => $usuarioBD['nombre'],
                'email' => $usuarioBD['email'],
                'permisos' => $usuarioBD['permisos']
            ];

            header("Location: ../../index/index.html.php");
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: ../login.html.php?error=1");
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: ../login.html.php?error=1");
        exit();
    }
} else {
    header("Location: ../login.html.php");
    exit();
}
?>
