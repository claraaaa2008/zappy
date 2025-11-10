<?php
session_start();
header("Content-Type: application/json");
require_once "BaseDatos.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Verificar usuario autenticado
    if (!isset($_SESSION['usuario']['idUsr'])) {
        http_response_code(401);
        echo json_encode(["error" => "Usuario no autenticado"]);
        exit;
    }

    $id_usuario = $_SESSION['usuario']['idUsr'];
    $id_juego = isset($_GET['id_juego']) ? intval($_GET['id_juego']) : null;

    $db = new BaseDatos();

    // Obtener puntaje total del usuario para el juego específico o total
    $puntaje = $db->obtenerPuntajeTotalUsuario($id_usuario, $id_juego);

    // Cerrar conexión
    $db->cerrarConexion();

    // Responder con el puntaje
    echo json_encode(["puntaje" => $puntaje]);
}
?>
