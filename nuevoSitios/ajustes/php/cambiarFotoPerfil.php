<?php
session_start();
require_once "../../../persistencia/BaseDatos.php";
header("Content-Type: application/json; charset=utf-8");

if (!isset($_SESSION['usuario']['idUsr'])) {
    echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
    exit;
}

$idUsr = $_SESSION['usuario']['idUsr'];
$db = new BaseDatos();

if (empty($_FILES['foto']['name'])) {
    echo json_encode(["success" => false, "message" => "No se envió ninguna foto"]);
    exit;
}

$ruta = "../../../img/perfiles/";
if (!is_dir($ruta)) mkdir($ruta, 0777, true);

$archivo = $_FILES['foto']['name'];
$tmp = $_FILES['foto']['tmp_name'];
$ext = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
$permitidas = ["jpg","jpeg","png","gif","webp"];

if (!in_array($ext, $permitidas)) {
    echo json_encode(["success" => false, "message" => "Formato no permitido"]);
    exit;
}

$nuevoNombre = "usr_" . $idUsr . "." . $ext;

if (!move_uploaded_file($tmp, $ruta . $nuevoNombre)) {
    echo json_encode(["success" => false, "message" => "Error al guardar la foto"]);
    exit;
}

$sql = "UPDATE Usuario SET fotoPerfil = ? WHERE idUsr = ?";
$db->ejecutar($sql, "si", $nuevoNombre, $idUsr);
$_SESSION['usuario']['fotoPerfil'] = $nuevoNombre;

echo json_encode(["success" => true, "foto" => $nuevoNombre, "message" => "Foto actualizada correctamente"]);
?>
