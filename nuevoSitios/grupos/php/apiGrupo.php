<?php
require_once "../../../persistencia/BaseDatos.php";
header("Content-Type: application/json; charset=utf-8");

$db = new BaseDatos();
$action = $_GET["action"] ?? $_POST["action"] ?? null;

if (!$action) {
    echo json_encode(["success" => false, "message" => "Falta parámetro 'action'"]);
    exit;
}

switch ($action) {
    // Crear grupo
    case "crear":
        $data = json_decode(file_get_contents("php://input"), true);
        if (
            isset($data["nomGrupo"]) &&
            isset($data["descripcion"]) &&
            isset($data["codigoGrupo"]) &&
            isset($data["tipoUsr"]) &&
            isset($data["idCreador"])
        ) {
            $ok = $db->crearGrupo(
                $data["nomGrupo"],
                $data["descripcion"],
                $data["codigoGrupo"],
                $data["tipoUsr"],
                $data["idCreador"]
            );
            echo json_encode([
                "success" => $ok,
                "message" => $ok ? "Grupo creado correctamente" : "Error al crear el grupo"
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Faltan datos"]);
        }
        break;

    // Listar grupos
    case "listar":
        $grupos = $db->obtenerGrupos();
        echo json_encode($grupos);
        break;

    // Actualizar grupo
    case "actualizar":
        $data = json_decode(file_get_contents("php://input"), true);
        if (
            isset($data["idGrupo"]) &&
            isset($data["nomGrupo"]) &&
            isset($data["descripcion"]) &&
            isset($data["tipoUsr"])
        ) {
            $ok = $db->actualizarGrupo(
                $data["idGrupo"],
                $data["nomGrupo"],
                $data["descripcion"],
                $data["tipoUsr"]
            );
            echo json_encode([
                "success" => $ok,
                "message" => $ok ? "Grupo actualizado correctamente" : "Error al actualizar el grupo"
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Faltan datos"]);
        }
        break;

    // Eliminar grupo
    case "eliminar":
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data["idGrupo"])) {
            $ok = $db->eliminarGrupo($data["idGrupo"]);
            echo json_encode([
                "success" => $ok,
                "message" => $ok ? "Grupo eliminado correctamente" : "Error al eliminar el grupo"
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Falta idGrupo"]);
        }
        break;

    default:
        echo json_encode(["success" => false, "message" => "Acción inválida"]);
}

$db->cerrarConexion();
?>
