<?php
session_start();

$usuario_valido = "admin";
$contrasena_valida = "1234";

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

if ($usuario === $usuario_valido && $contrasena === $contrasena_valida) {
    $_SESSION['usuario'] = $usuario;
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: ../loginprueba.php?error=1");
    exit();
}