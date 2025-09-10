}<?php
class BaseDatos {
    private $conexion;
    private $servidor = "localhost";
    private $usuario = "root";
    private $password = "";
    private $base_datos = "zappymenu"; // Cambiado a la nueva DB

    public function __construct() {
        $this->conexion = $this->nuevaConexion(
            $this->servidor,
            $this->usuario,
            $this->password,
            $this->base_datos
        );
    }

    private function nuevaConexion($server, $user, $pass, $base) {
        $conectar = new mysqli($server, $user, $pass, $base);
        if ($conectar->connect_error) {
            die("Error de conexión: " . $conectar->connect_error);
        }
        $conectar->set_charset("utf8mb4");
        return $conectar;
    }

    /* =========================
       MÉTODOS DE CONSULTAS GENÉRICAS
       ========================= */
    public function ejecutar($sql, $tipos, ...$params) {
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare: " . $this->conexion->error);
        }
        $stmt->bind_param($tipos, ...$params);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function consultar($sql, $tipos = "", ...$params) {
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare: " . $this->conexion->error);
        }
        if ($tipos !== "") {
            $stmt->bind_param($tipos, ...$params);
        }
        $stmt->execute();
        $resultado = $stmt->get_result();
        $filas = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $filas;
    }

    /* =========================
       MÉTODOS PARA USUARIOS
       ========================= */
    public function usuarioExiste($nombreUsuario) {
        $sql = "SELECT idUsr FROM Usuario WHERE nom_usr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare usuarioExiste: " . $this->conexion->error);
        }
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $existe = $result->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    public function cambiarNombreUsuario($idUsuario, $nuevoUsuario) {
        if ($this->usuarioExiste($nuevoUsuario)) {
            return false; // ya existe
        }
        $sql = "UPDATE Usuario SET nom_usr = ? WHERE idUsr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare cambiarNombreUsuario: " . $this->conexion->error);
        }
        $stmt->bind_param("si", $nuevoUsuario, $idUsuario);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    public function verificarContrasena($idUsuario, $contrasena) {
        $sql = "SELECT contrasena FROM Usuario WHERE idUsr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare verificarContrasena: " . $this->conexion->error);
        }
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();

        if ($usuario) {
            return password_verify($contrasena, $usuario['contrasena']);
        }
        return false;
    }

    public function cambiarContrasena($idUsuario, $nuevaContrasenaHasheada) {
        $sql = "UPDATE Usuario SET contrasena = ? WHERE idUsr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare cambiarContrasena: " . $this->conexion->error);
        }
        $stmt->bind_param("si", $nuevaContrasenaHasheada, $idUsuario);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    public function obtenerHashContrasena($idUsuario) {
        $sql = "SELECT contrasena FROM Usuario WHERE idUsr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            error_log("Error en prepare obtenerHashContrasena: " . $this->conexion->error);
            return null;
        }
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        $stmt->close();
        return $fila ? $fila['contrasena'] : null;
    }

    public function eliminarCuenta($idUsuario) {
        $sql = "DELETE FROM Usuario WHERE idUsr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare eliminarCuenta: " . $this->conexion->error);
        }
        $stmt->bind_param("i", $idUsuario);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    /* =========================
       CERRAR CONEXIÓN
       ========================= */
    public function cerrarConexion() {
        $this->conexion->close();
    }
}
?>
