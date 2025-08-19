<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
    header("Location: ../../login/login.html.php");
    exit();
}

require_once(__DIR__ . '/../../../persistencia/BaseDatos.php');

$usuario = $_SESSION['usuario'];
$bd = new BaseDatos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contrasenaActual = trim($_POST['contrasena'] ?? '');
    $nuevaContrasena = trim($_POST['nuevaContrasena'] ?? '');
    $confirmarContrasena = trim($_POST['confirmarContrasena'] ?? '');

    if (empty($contrasenaActual) || empty($nuevaContrasena) || empty($confirmarContrasena)) {
        $bd->cerrarConexion();
        header("Location: ../opcionesCuenta.html.php?error=campos_vacios");
        exit();
    }

    if (strlen($nuevaContrasena) < 8) {
        $bd->cerrarConexion();
        header("Location: ../opcionesCuenta.html.php?error=contrasena_corta");
        exit();
    }

    if ($nuevaContrasena !== $confirmarContrasena) {
        $bd->cerrarConexion();
        header("Location: ../opcionesCuenta.html.php?error=no_coinciden");
        exit();
    }

    $hashActual = $bd->obtenerHashContrasena($usuario['id']);

    if (!$hashActual) {
        $bd->cerrarConexion();
        header("Location: ../opcionesCuenta.html.php?error=cuenta_no_verificada");
        exit();
    }

    if (!password_verify($contrasenaActual, $hashActual)) {
        $bd->cerrarConexion();
        header("Location: ../opcionesCuenta.html.php?error=incorrecta");
        exit();
    }

    $hashNuevaContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
    $resultadoCambio = $bd->cambiarContrasena($usuario['id'], $hashNuevaContrasena);

    $bd->cerrarConexion();

    if ($resultadoCambio) {
        header("Location: ../opcionesCuenta.html.php?success=1");
    } else {
        header("Location: ../opcionesCuenta.html.php?error=bd");
    }
    exit();
}
?>
