<?php
require_once "../../../persistencia/BaseDatos.php";

if (!isset($_POST['idUsr'])) {
    die("Falta el ID del usuario.");
}

$idUsr = intval($_POST['idUsr']);
$db = new BaseDatos();

$sql = "UPDATE usuario SET esAdmin = 1 WHERE idUsr = ?";
$stmt = $db->getConexion()->prepare($sql);
$stmt->bind_param("i", $idUsr);

if ($stmt->execute()) {
    header("Location: ../ajustes.html.php?mensaje=admin_ok");
    exit;
} else {
    header("Location: ../ajustes.html.php?mensaje=admin_error");
    exit;
}

