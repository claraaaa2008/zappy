<?php
require_once "../../../persistencia/BaseDatos.php";

header("Content-Type: application/json; charset=utf-8");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (
        isset($data["nomGrupo"]) &&
        isset($data["descripcionGrupo"]) &&
        isset($data["fechaCreacion"]) &&
        isset($data["estadoGrupo"]) &&
        isset($data["tipoUsr"])
    ) {
        $db = new BaseDatos();
        $ok = $db->crearGrupo(
            $data["nomGrupo"],
            $data["descripcionGrupo"],
            $data["fechaCreacion"],
            $data["estadoGrupo"],
            $data["tipoUsr"]
        );

        echo json_encode([
            "success" => $ok,
            "message" => $ok ? "Grupo creado correctamente" : "Error al crear el grupo"
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Faltan datos"]);
    }
}
?>
