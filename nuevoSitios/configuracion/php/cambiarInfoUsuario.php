<?php
session_start();
require_once "../../persistencia/BaseDatos.php";

if (!isset($_SESSION['usuario']['idUsr'])) {
    echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
    exit;
}

$idUsr = $_SESSION['usuario']['idUsr'];
$nombre = $_POST['nombre'] ?? null;
$correo = $_POST['correo'] ?? null;
$genero = $_POST['genero'] ?? null;
$fecha_nac = $_POST['fecha_nac'] ?? null;

$db = new BaseDatos();
$conn = $db->getConexion();

$sql = "UPDATE Usuario 
        SET nom_real = ?, correo = ?, genero = ?, fecha_nac = ?
        WHERE idUsr = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $nombre, $correo, $genero, $fecha_nac, $idUsr);

if ($stmt->execute()) {
    $_SESSION['usuario']['nom_real'] = $nombre;
    $_SESSION['usuario']['correo'] = $correo;
    echo json_encode(["success" => true, "message" => "Datos actualizados correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al actualizar los datos"]);
}
?>
