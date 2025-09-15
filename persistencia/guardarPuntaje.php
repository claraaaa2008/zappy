<?php
session_start(); 
header("Content-Type: application/json");

// --- Configuración para manejar errores ---
ini_set('display_errors', 0);     // Evita mostrar errores en pantalla (solo en logs)
error_reporting(E_ALL);           // Captura todos los niveles de error

require_once __DIR__ . "/../persistencia/BaseDatos.php"; 
// Incluye la clase BaseDatos (ruta relativa)

// --- Verificar si el usuario está logueado ---
if (!isset($_SESSION['usuario']['idUsr'])) {
    http_response_code(401); // 401 = No autorizado
    echo json_encode(["error" => "Usuario no autenticado"]);
    exit();
}

// --- Leer datos enviados desde JavaScript (fetch) ---
$data = json_decode(file_get_contents("php://input"), true);

$id_juego = $data['id_juego'] ?? null;   // ID del juego
$puntaje = $data['puntaje'] ?? null;     // Puntaje alcanzado

// Validación: si faltan datos, se responde con error 400
if ($id_juego === null || $puntaje === null) {
    http_response_code(400);
    echo json_encode(["error" => "Datos incompletos"]);
    exit();
}

try {
    // --- Conexión a la base de datos ---
    $bd = new BaseDatos();
    $conexion = $bd->getConexion();

    // --- Insertar puntaje ---
    // Se usa "ON DUPLICATE KEY UPDATE" para actualizar si ya existe registro del usuario en ese juego
    // `GREATEST(sumPuntos, VALUES(sumPuntos))` asegura guardar SOLO el puntaje más alto
    $stmt = $conexion->prepare("
        INSERT INTO Juega (idUsr, idJuego, sumPuntos)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE sumPuntos = GREATEST(sumPuntos, VALUES(sumPuntos))
    ");

    if (!$stmt) {
        throw new Exception($conexion->error); // Lanza excepción si falla la preparación
    }

    // Vincula parámetros: idUsr (usuario actual), id_juego y puntaje
    $stmt->bind_param("iii", $_SESSION['usuario']['idUsr'], $id_juego, $puntaje);
    $success = $stmt->execute(); // Ejecuta el INSERT/UPDATE
    $stmt->close();
    $bd->cerrarConexion();

    // --- Respuesta al cliente ---
    if ($success) {
        echo json_encode(["success" => true]); // Guardado correcto
    } else {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo guardar el puntaje"]);
    }

} catch (Exception $e) {
    // Manejo de errores inesperados
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
