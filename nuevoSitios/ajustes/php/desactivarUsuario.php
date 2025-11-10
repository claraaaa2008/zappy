<?php
require_once "../../../persistencia/BaseDatos.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idUsr = $_POST["idUsr"] ?? null;

    if (!$idUsr) {
        echo json_encode(["success" => false, "message" => "Falta ID de usuario"]);
        exit;
    }

    $db = new BaseDatos();
    $conexion = $db->getConexion();

    // Primero obtenemos el estado actual del usuario
    $sqlEstado = "SELECT activo FROM usuario WHERE idUsr = ?";
    $stmt = $conexion->prepare($sqlEstado);
    $stmt->bind_param("i", $idUsr);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if (!$usuario) {
        echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
        exit;
    }

    // Cambiar el valor de activo (0 → 1 o 1 → 0)
    $nuevoEstado = $usuario["activo"] ? 0 : 1;
    $sqlUpdate = "UPDATE usuario SET activo = ? WHERE idUsr = ?";
    $stmt2 = $conexion->prepare($sqlUpdate);
    $stmt2->bind_param("ii", $nuevoEstado, $idUsr);
    $stmt2->execute();

    if ($stmt2->affected_rows > 0) {
        $mensaje = $nuevoEstado ? "Usuario reactivado correctamente" : "Usuario desactivado correctamente";
        echo json_encode(["success" => true, "message" => $mensaje]);
    } else {
        echo json_encode(["success" => false, "message" => "No se pudo cambiar el estado"]);
    }
}
?>
