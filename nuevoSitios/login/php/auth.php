<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $conexion = new mysqli("localhost", "root", "", "zappymenu"); // Cambiado a la nueva DB
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Solo usuarios verificados pueden iniciar sesión
    $sql = "SELECT * FROM Usuario WHERE nom_usr = ?";
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
                'idUsr' => $usuarioBD['idUsr'],
                'nom_usr' => $usuarioBD['nom_usr'],
                'nom_real' => $usuarioBD['nom_real'],
                'correo' => $usuarioBD['correo'],
                'idGrupo' => $usuarioBD['idGrupo']
            ];
            header("Location: ../../index/index.html.php");
            exit();
        } else {
            header("Location: ../login.html.php?error=1"); // Contraseña incorrecta
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: ../login.html.php?error=2");
        exit();
    }
} else {
    header("Location: ../login.html.php");
    exit();
}
?>
