<?php
session_start();
require_once "../../../persistencia/BaseDatos.php";

if (!isset($_SESSION['usuario']['idUsr'])) {
    header("Location: ../../index/index.html.php");
    exit;
}

$idUsr = $_SESSION['usuario']['idUsr'];
$db = new BaseDatos();
$db->eliminarCuenta($idUsr);

session_destroy();
header("Location: ../../index/index.html.php"); // redirige al inicio
exit;
?>
