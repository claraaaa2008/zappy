<?php
session_start();
require_once "../../../persistencia/BaseDatos.php";  // Ajusta si la ruta es diferente (ej. "../persistencia/BaseDatos.php" si php/ está en raíz)
header("Content-Type: application/json; charset=utf-8");

error_log("PHP ejecutado: actualizarUsuarioAdmin.php - Inicio");  // Agregado para debug

if (!isset($_SESSION['usuario']['esAdmin']) || $_SESSION['usuario']['esAdmin'] != 1) {
    error_log("PHP: No autorizado");  // Agregado
    echo json_encode(["success" => false, "message" => "No autorizado"]);
    exit;
}

$idUsr = $_POST['idUsr'] ?? null;
$nombre = trim($_POST['nombre'] ?? '');
$contrasena = trim($_POST['contrasena'] ?? '');

error_log("PHP: Datos recibidos - idUsr: $idUsr, nombre: $nombre, contrasena: " . (empty($contrasena) ? 'vacía' : 'presente'));  // Agregado

if (!$idUsr) {
    error_log("PHP: Falta ID de usuario");  // Agregado
    echo json_encode(["success" => false, "message" => "Falta ID de usuario"]);
    exit;
}

$db = new BaseDatos();
$actualizado = false;

if ($nombre !== '') {
    if (!$db->cambiarNombreUsuario($idUsr, $nombre)) {
        error_log("PHP: Error cambiando nombre - ya existe o fallo");  // Agregado
        echo json_encode(["success" => false, "message" => "El nombre ya existe o no se pudo actualizar"]);
        exit;
    }
    $actualizado = true;
    error_log("PHP: Nombre actualizado");  // Agregado
}

if ($contrasena !== '') {
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $sql = "UPDATE Usuario SET contrasena = ? WHERE idUsr = ?";
    $db->ejecutar($sql, "si", $hash, $idUsr);
    $actualizado = true;
    error_log("PHP: Contraseña actualizada");  // Agregado
}

if ($actualizado) {
    error_log("PHP: Actualización exitosa");  // Agregado
    echo json_encode(["success" => true, "message" => "✅ Usuario actualizado correctamente"]);
} else {
    error_log("PHP: No se realizaron cambios");  // Agregado
    echo json_encode(["success" => false, "message" => "No se realizaron cambios"]);
}
exit;