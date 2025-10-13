<?php
require_once "../../../persistencia/BaseDatos.php";

header("Content-Type: application/json; charset=utf-8");

$db = new BaseDatos();
$grupos = $db->obtenerGrupos();
echo json_encode($grupos);
?>
