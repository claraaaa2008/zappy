<?php
session_start();
require_once "../../persistencia/BaseDatos.php";

if (!isset($_SESSION['usuario']['idUsr'])) {
    header("Location: ../../login/login.html.php");
    exit;
}

$idUsr = $_SESSION['usuario']['idUsr'];
$db = new BaseDatos();
$conn = $db->getConexion();

$sql = "DELETE FROM Usuario WHERE idUsr = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsr);

if ($stmt->execute()) {
    session_unset();
    session_destroy();
    header("Location: ../../login/login.html.php?deleted=1");
    exit;
} else {
    echo "Error al eliminar la cuenta.";
}
?>
