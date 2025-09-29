<?php
header("Content-Type: application/json");
require_once "BaseDatos.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["id_usuario"], $data["id_juego"], $data["puntaje"])) {
        $db = new BaseDatos();

        $ok = $db->ejecutar(
            "INSERT INTO partida (id_usuario, id_juego, puntaje) VALUES (?, ?, ?)",
            "iii",
            $data["id_usuario"],
            $data["id_juego"],
            $data["puntaje"]
        );

        $db->cerrarConexion();

        if ($ok) {
            echo json_encode(["success" => true]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "No se pudo guardar el puntaje"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Datos incompletos"]);
    }
}
?>
