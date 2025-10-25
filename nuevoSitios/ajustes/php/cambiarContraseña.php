<?php
session_start();
require_once "../../../persistencia/BaseDatos.php";

header("Content-Type: application/json; charset=utf-8");

if (!isset($_SESSION['usuario']['idUsr'])) {
    echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
    exit;
}

$idUsr = $_SESSION['usuario']['idUsr'];
$actual = $_POST['contraseña_actual'] ?? '';
$nueva = $_POST['nueva_contraseña'] ?? '';
$confirmar = $_POST['confirmar_contraseña'] ?? '';

if (!$actual || !$nueva || !$confirmar) {
    echo json_encode(["success" => false, "message" => "Complete todos los campos"]);
    exit;
}

if ($nueva !== $confirmar) {
    echo json_encode(["success" => false, "message" => "Las contraseñas no coinciden"]);
    exit;
}

$db = new BaseDatos();

if (!$db->verificarContrasena($idUsr, $actual)) {
    echo json_encode(["success" => false, "message" => "Contraseña actual incorrecta"]);
    exit;
}

// Hasheamos la nueva contraseña
$nuevaHasheada = password_hash($nueva, PASSWORD_DEFAULT);
$db->cambiarContrasena($idUsr, $nuevaHasheada);

echo json_encode(["success" => true, "message" => "Contraseña cambiada correctamente"]);
?>
