<?php
session_start();
header("Content-Type: application/json");
require_once "BaseDatos.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar usuario en sesión
    if (!isset($_SESSION["id_usuario"])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuario no autenticado"]);
        exit;
    }

    $id_usuario = $_SESSION["id_usuario"];
    $id_juego   = $data["id_juego"] ?? null;
    $puntaje    = $data["puntaje"] ?? null;

    if ($id_juego && $puntaje !== null) {
        $db = new BaseDatos();

        $ok = $db->ejecutar(
            "INSERT INTO partida (id_usuario, id_juego, puntaje) VALUES (?, ?, ?)",
            "iii",
            $id_usuario,
            $id_juego,
            $puntaje
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
