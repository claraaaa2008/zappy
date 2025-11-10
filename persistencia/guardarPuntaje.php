<?php
session_start();
header("Content-Type: application/json");
require_once "BaseDatos.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar usuario autenticado
    if (!isset($_SESSION['usuario']['idUsr'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuario no autenticado"]);
        exit;
    }

    $id_usuario = $_SESSION['usuario']['idUsr'];
    $id_juego   = $data["id_juego"] ?? null;
    $puntaje    = $data["puntaje"] ?? null;

    // Validar datos
    echo "guardar puntaje";
    if ($id_juego && $puntaje !== null) {
        $db = new BaseDatos();

        // Insertar puntaje en la tabla Juega
        $ok = $db->ejecutar(
            "INSERT INTO Juega (idUsr, idJuego, sumPuntos) VALUES (?, ?, ?)",
            "iii",
            $id_usuario,
            $id_juego,
            $puntaje
        );

        // Cerrar conexión
        $db->cerrarConexion();

        // Responder al frontend
        if ($ok) {
            echo json_encode( ["success" => true]);
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