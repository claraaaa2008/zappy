<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
    // Usuario no autenticado o sesión incorrecta
    header("Location: ../../login/login.html.php");
    exit();
}

require_once(__DIR__ . '/../../../persistencia/BaseDatos.php');

$usuario = $_SESSION['usuario'];
$bd = new BaseDatos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoUsuario = trim($_POST['nuevo_usuario']);

    // Validar que no esté vacío
    if (empty($nuevoUsuario)) {
        header("Location: ../opcionesCuenta.html.php?error=1");
        exit();
    }

    // Intentar cambiar nombre de usuario
    $resultado = $bd->cambiarNombreUsuario($usuario['id'], $nuevoUsuario);

    if ($resultado) {
        // Actualizar el nombre de usuario en sesión
        $_SESSION['usuario']['nombre_usuario'] = $nuevoUsuario;
        header("Location: ../opcionesCuenta.html.php?success=1");
    } else {
        // Error: usuario ya existe o fallo en la consulta
        header("Location: ../opcionesCuenta.html.php?error=1");
    }

    $bd->cerrarConexion();
    exit();
} else {
    // Método no permitido o acceso directo
    header("Location: ../opcionesCuenta.html.php");
    exit();
}
?>
