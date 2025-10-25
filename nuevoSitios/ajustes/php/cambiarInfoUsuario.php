<?php
session_start();
require_once "../../../persistencia/BaseDatos.php";

header("Content-Type: application/json; charset=utf-8");

if (!isset($_SESSION['usuario']['idUsr'])) {
    echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
    exit;
}

$idUsr = $_SESSION['usuario']['idUsr'];
$nombre = $_POST['nombre'] ?? null;
$correo = $_POST['email'] ?? null;
$genero = $_POST['genero'] ?? null;
$fecha_nac = $_POST['fecha_nacimiento'] ?? null;

$db = new BaseDatos();

if (!$nombre && !$correo && !$genero && !$fecha_nac && empty($_FILES['fotoPerfil']['name'])) {
    echo json_encode(["success" => false, "message" => "No se enviaron datos"]);
    exit;
}

// Cambios de nombre
if ($nombre) {
    if (!$db->cambiarNombreUsuario($idUsr, $nombre)) {
        echo json_encode(["success" => false, "message" => "Nombre ya existe"]);
        exit;
    }
}

// Cambios de correo
if ($correo) {
    $sql = "UPDATE Usuario SET correo = ? WHERE idUsr = ?";
    $db->ejecutar($sql, "si", $correo, $idUsr);
}

// Cambios de género
if ($genero) {
    $sql = "UPDATE Usuario SET genero = ? WHERE idUsr = ?";
    $db->ejecutar($sql, "si", $genero, $idUsr);
}

// Cambios de fecha de nacimiento
if ($fecha_nac) {
    $sql = "UPDATE Usuario SET fecha_nac = ? WHERE idUsr = ?";
    $db->ejecutar($sql, "si", $fecha_nac, $idUsr);
}

// Subir foto de perfil
if (!empty($_FILES['fotoPerfil']['name'])) {
    $ruta = "../../../img/perfiles/";
    if(!is_dir($ruta)) mkdir($ruta, 0777, true);

    $archivo = $_FILES['fotoPerfil']['name'];
    $tmp = $_FILES['fotoPerfil']['tmp_name'];
    $ext = pathinfo($archivo, PATHINFO_EXTENSION);
    $nuevoNombre = "usr_".$idUsr.".".$ext;

    if (move_uploaded_file($tmp, $ruta.$nuevoNombre)) {
        $sql = "UPDATE Usuario SET fotoPerfil = ? WHERE idUsr = ?";
        $db->ejecutar($sql, "si", $nuevoNombre, $idUsr);
    } else {
        echo json_encode(["success" => false, "message" => "Error al subir la foto"]);
        exit;
    }
}

echo json_encode(["success" => true, "message" => "Datos actualizados correctamente", "foto" => $nuevoNombre ?? null]);
?>
