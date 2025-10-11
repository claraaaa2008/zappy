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
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $fecha = trim($_POST['fecha'] ?? '');

    if (empty($nombre) || empty($correo)) {
        header("Location: ../configuracion.html?error=campos_vacios");
        exit();
    }

    $resultado = $bd->cambiarInfoUsuario(
        $usuario['idUsr'],
        $nombre,
        $correo,
        $genero,
        $fecha
    );

    if ($resultado) {
        $_SESSION['usuario']['nom_usr'] = $nombre;
        $_SESSION['usuario']['correo'] = $correo;
        header("Location: ../configuracion.html?success=1");
    } else {
        header("Location: ../configuracion.html?error=bd");
    }

    $bd->cerrarConexion();
    exit();
} else {
    header("Location: ../configuracion.html");
    exit();
}
