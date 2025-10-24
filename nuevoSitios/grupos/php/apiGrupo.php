<?php
session_start();
require_once "../../../persistencia/BaseDatos.php";
header("Content-Type: application/json; charset=utf-8");

$db = new BaseDatos();
$action = $_GET["action"] ?? $_POST["action"] ?? null;

if (!$action) {
    echo json_encode(["success" => false, "message" => "Falta parámetro 'action'"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

switch ($action) {
    // =====================================================
    // CREAR GRUPO
    // =====================================================
    case "crear":
        if (isset($data["nomGrupo"], $data["descripcionGrupo"])) {
            $nomGrupo = $data["nomGrupo"];
            $descripcion = $data["descripcionGrupo"];
            $idCreador = $_SESSION['usuario']['idUsr'] ?? null;

            if (!$idCreador) {
                echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
                break;
            }

            $codigoGrupo = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);

            $conexion = $db->getConexion();
            $stmt = $conexion->prepare("
                INSERT INTO Grupo (nomGrupo, descripcion, codigoGrupo, idCreador)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("sssi", $nomGrupo, $descripcion, $codigoGrupo, $idCreador);
            $ok = $stmt->execute();

            echo json_encode([
                "success" => $ok,
                "message" => $ok ? "Grupo creado correctamente" : "Error al crear el grupo",
                "codigo" => $ok ? $codigoGrupo : null
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Faltan datos"]);
        }
        break;

    // =====================================================
    // LISTAR TODOS LOS GRUPOS CON MIEMBROS
    // =====================================================
    case "listar":
        $conexion = $db->getConexion();
        $resultado = $conexion->query("SELECT * FROM Grupo");
        $grupos = $resultado->fetch_all(MYSQLI_ASSOC);

        foreach ($grupos as &$grupo) {
            $stmt = $conexion->prepare("SELECT nom_usr FROM Usuario WHERE idGrupo = ?");
            $stmt->bind_param("i", $grupo['idGrupo']);
            $stmt->execute();
            $res = $stmt->get_result();
            $miembros = $res->fetch_all(MYSQLI_ASSOC);
            $grupo['miembros'] = array_map(fn($m) => $m['nom_usr'], $miembros);
        }

        echo json_encode($grupos);
        break;

    // =====================================================
    // LISTAR GRUPOS DEL USUARIO
    // =====================================================
    case "misGrupos":
        $idUsr = $_SESSION['usuario']['idUsr'] ?? null;
        if (!$idUsr) {
            echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
            break;
        }

        $conexion = $db->getConexion();
        $stmt = $conexion->prepare("
            SELECT g.idGrupo, g.nomGrupo, g.descripcion, g.codigoGrupo
            FROM Grupo g
            JOIN Usuario u ON u.idGrupo = g.idGrupo
            WHERE u.idUsr = ?
        ");
        $stmt->bind_param("i", $idUsr);
        $stmt->execute();
        $res = $stmt->get_result();
        $grupos = $res->fetch_all(MYSQLI_ASSOC);

        foreach ($grupos as &$grupo) {
            $stmt2 = $conexion->prepare("SELECT nom_usr FROM Usuario WHERE idGrupo = ?");
            $stmt2->bind_param("i", $grupo['idGrupo']);
            $stmt2->execute();
            $res2 = $stmt2->get_result();
            $miembros = $res2->fetch_all(MYSQLI_ASSOC);
            $grupo['miembros'] = array_map(fn($m) => $m['nom_usr'], $miembros);
        }

        echo json_encode(["success" => true, "grupos" => $grupos]);
        break;

    // =====================================================
    // UNIRSE A GRUPO
    // =====================================================
    case "unirse":
        if (isset($data["codigoGrupo"])) {
            $idUsr = $_SESSION['usuario']['idUsr'] ?? null;
            if (!$idUsr) {
                echo json_encode(["success" => false, "message" => "Sesión no iniciada"]);
                break;
            }

            $conexion = $db->getConexion();
            $stmt = $conexion->prepare("SELECT idGrupo FROM Grupo WHERE codigoGrupo = ?");
            $stmt->bind_param("s", $data["codigoGrupo"]);
            $stmt->execute();
            $res = $stmt->get_result();
            $grupo = $res->fetch_assoc();

            if ($grupo) {
                $stmt2 = $conexion->prepare("UPDATE Usuario SET idGrupo = ? WHERE idUsr = ?");
                $stmt2->bind_param("ii", $grupo['idGrupo'], $idUsr);
                $ok = $stmt2->execute();
                echo json_encode(["success" => $ok, "message" => $ok ? "Te uniste al grupo" : "Error al unirse"]);
            } else {
                echo json_encode(["success" => false, "message" => "Código de grupo inválido"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Falta código de grupo"]);
        }
        break;

    // =====================================================
    // ELIMINAR GRUPO
    // =====================================================
    case "eliminar":
        if (isset($data["idGrupo"])) {
            $conexion = $db->getConexion();
            $stmt = $conexion->prepare("DELETE FROM Grupo WHERE idGrupo = ?");
            $stmt->bind_param("i", $data["idGrupo"]);
            $ok = $stmt->execute();
            echo json_encode(["success" => $ok, "message" => $ok ? "Grupo eliminado" : "Error al eliminar"]);
        } else {
            echo json_encode(["success" => false, "message" => "Falta idGrupo"]);
        }
        break;

    default:
        echo json_encode(["success" => false, "message" => "Acción inválida"]);
}

$db->cerrarConexion();
?>
