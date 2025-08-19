<?php
session_start();

require_once(__DIR__ . '/../../../persistencia/BaseDatos.php');

if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
    // Usuario no logueado
    header("Location: ../../login/login.html.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$bd = new BaseDatos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí podrías agregar validaciones extra, como pedir la contraseña antes de borrar

    $resultado = $bd->eliminarCuenta($usuario['id']);
    $bd->cerrarConexion();

    if ($resultado) {
        // Destruir sesión al eliminar la cuenta
        session_destroy();

        // Redirigir a página de confirmación o inicio
        header("Location: ../../login/login.html.php?cuenta_eliminada=1");
        exit();
    } else {
        // Error al eliminar
        header("Location: ../opcionesCuenta.html.php?error=eliminar");
        exit();
    }
} else {
    // Si no es POST, simplemente redirigir o mostrar mensaje
    header("Location: ../opcionesCuenta.html.php");
    exit();
}
