<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['idUsr'])) {
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
        header("Location: ../configuracion.html?error=campos_vacios");
        exit();
    }

    if (strlen($nuevaContrasena) < 8) {
        $bd->cerrarConexion();
        header("Location: ../configuracion.html?error=contrasena_corta");
        exit();
    }

    if ($nuevaContrasena !== $confirmarContrasena) {
        $bd->cerrarConexion();
        header("Location: ../configuracion.html?error=no_coinciden");
        exit();
    }

    $hashActual = $bd->obtenerHashContrasena($usuario['idUsr']);

    if (!$hashActual) {
        $bd->cerrarConexion();
        header("Location: ../configuracion.html?error=cuenta_no_verificada");
        exit();
    }

    if (!password_verify($contrasenaActual, $hashActual)) {
        $bd->cerrarConexion();
        header("Location: ../configuracion.html?error=incorrecta");
        exit();
    }

    $hashNuevaContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
    $resultadoCambio = $bd->cambiarContrasena($usuario['idUsr'], $hashNuevaContrasena);

    $bd->cerrarConexion();

    if ($resultadoCambio) {
        header("Location: ../configuracion.html?success=1");
    } else {
        header("Location: ../configuracion.html?error=bd");
    }
    exit();
}
