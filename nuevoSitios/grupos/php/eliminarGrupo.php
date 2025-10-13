<?php
require_once "../../../persistencia/BaseDatos.php";

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["idGrupo"])) {
        $db = new BaseDatos();
        $ok = $db->eliminarGrupo($data["idGrupo"]);

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Grupo eliminado correctamente" : "Error al eliminar el grupo"
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Falta el idGrupo"]);
    }
}
?>
