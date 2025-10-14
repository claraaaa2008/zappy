<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $nombre = $_POST['nombre']; // nom_real
    $email = $_POST['email'];   // correo
    $fechaNacimiento = date('Y-m-d', strtotime($_POST['fechaNacimiento'])); // Formato YYYY-MM-DD
    $sexo = $_POST['sexo'];

    // Ajuste ENUM
    if ($sexo === 'Masculino') $sexo = 'M';
    elseif ($sexo === 'Femenino') $sexo = 'F';
    else $sexo = 'Otro';

    $conexion = new mysqli("localhost", "root", "", "zappymenu");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Hashear la contraseña
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Usuario (nom_usr, contrasena, nom_real, correo, fecha_nac, genero)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    if (!$stmt) die("Error en prepare: " . $conexion->error);

    $stmt->bind_param("ssssss", $usuario, $hash, $nombre, $email, $fechaNacimiento, $sexo);

    if ($stmt->execute()) {
        $_SESSION['usuario'] = [
            'idUsr' => $conexion->insert_id,
            'nom_usr' => $usuario,
            'nom_real' => $nombre,
            'correo' => $email,
            'idGrupo' => null
        ];

        $stmt->close();
        $conexion->close();
        header("Location: ../../index/index.html");
        exit();
    } else {
        $stmt->close();
        $conexion->close();
        header("Location: ../../signup/signup.html.php?error=1");
        exit();
    }
} else {
    header("Location: ../signup.html.php");
    exit();
}

?>
