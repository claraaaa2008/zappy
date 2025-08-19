<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $conexion = new mysqli("localhost", "root", "", "zappyMenuDeJuegos");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Solo usuarios verificados pueden iniciar sesión
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error en prepare: " . $conexion->error);
    }
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuarioBD = $resultado->fetch_assoc();

        if (password_verify($contrasena, $usuarioBD['contrasena'])) {
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
            header("Location: ../login.html.php?error=1");
            exit();
        }
    } else {
        // Usuario no encontrado o no verificado
        header("Location: ../login.html.php?error=2");
        exit();
    }
} else {
    header("Location: ../login.html.php");
    exit();
}
?>
