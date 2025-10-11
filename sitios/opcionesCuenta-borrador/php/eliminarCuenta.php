<?php
session_start();
require_once(__DIR__ . '/../../../persistencia/BaseDatos.php');

if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['idUsr'])) {
    header("Location: ../../login/login.html.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$bd = new BaseDatos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $bd->eliminarCuenta($usuario['idUsr']);
    $bd->cerrarConexion();

    if ($resultado) {
        session_destroy();
        header("Location: ../../login/login.html.php?cuenta_eliminada=1");
        exit();
    } else {
        header("Location: ../configuracion.html?error=eliminar");
        exit();
    }
} else {
    header("Location: ../configuracion.html");
    exit();
}
