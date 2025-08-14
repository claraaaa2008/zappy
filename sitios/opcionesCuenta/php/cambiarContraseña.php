<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../login/login.html.php");
    exit();
}

require_once(__DIR__ . '/../../../persistencia/BaseDatos.php');

$usuario = $_SESSION['usuario'];
$bd = new BaseDatos();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contrasenaActual = $_POST['contrasena'] ?? '';
    $nuevaContrasena = $_POST['nuevaContrasena'] ?? '';
    $confirmarContrasena = $_POST['confirmarContrasena'] ?? '';

    // Validar que los campos no estén vacíos
    if (empty($contrasenaActual) || empty($nuevaContrasena) || empty($confirmarContrasena)) {
        header("Location: ../opcionesCuenta.html.php?error=1");
        exit();
    }

    // Validar que la nueva contraseña y la confirmación coincidan
    if ($nuevaContrasena !== $confirmarContrasena) {
        header("Location: ../opcionesCuenta.html.php?error=1");
        exit();
    }

    // Obtener el hash actual desde la base de datos usando el método de la clase
    $hashActual = $bd->obtenerHashContrasena($usuario['id']);
    if (!$hashActual || !password_verify($contrasenaActual, $hashActual)) {
        // La contraseña actual no coincide
        header("Location: ../opcionesCuenta.html.php?error=1");
        exit();
    }

    // Hashear la nueva contraseña
    $hashNuevaContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

    // Cambiar la contraseña usando el método de la clase
    $resultadoCambio = $bd->cambiarContrasena($usuario['id'], $hashNuevaContrasena);

    if ($resultadoCambio) {
        header("Location: ../opcionesCuenta.html.php?success=1");
    } else {
        header("Location: ../opcionesCuenta.html.php?error=1");
    }

    $bd->cerrarConexion();
    exit();
}
?>

