<?php
session_start();
require_once "../../persistencia/BaseDatos.php";

if (!isset($_SESSION['usuario']['idUsr'])) {
    echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
    exit;
}

$idUsr = $_SESSION['usuario']['idUsr'];
$contrasena = $_POST['contrasena'] ?? "";
$nueva = $_POST['nuevaContrasena'] ?? "";
$confirmar = $_POST['confirmarContrasena'] ?? "";

if ($nueva !== $confirmar) {
    echo json_encode(["success" => false, "message" => "Las contraseñas no coinciden"]);
    exit;
}

$db = new BaseDatos();
$conn = $db->getConexion();

// Obtener contraseña actual
$sql = "SELECT contrasena FROM Usuario WHERE idUsr = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsr);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();
    if (password_verify($contrasena, $usuario['contrasena'])) {
        $nuevaHash = password_hash($nueva, PASSWORD_DEFAULT);
        $sqlUpdate = "UPDATE Usuario SET contrasena = ? WHERE idUsr = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("si", $nuevaHash, $idUsr);
        if ($stmtUpdate->execute()) {
            echo json_encode(["success" => true, "message" => "Contraseña actualizada correctamente"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al guardar la nueva contraseña"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Contraseña actual incorrecta"]);
    }
}
?>
