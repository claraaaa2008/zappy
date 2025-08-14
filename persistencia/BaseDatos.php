<?php
class BaseDatos {

    private $servidor;
    private $usuario;
    private $password;
    private $base_datos;
    private $conexion;

    public function __construct() {
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->password = "";
        $this->base_datos = "zappyMenuDeJuegos";
        $this->conexion = $this->nuevaConexion($this->servidor, $this->usuario, $this->password, $this->base_datos);
    }

    private function nuevaConexion($server, $user, $pass, $base) {
        $conectar = new mysqli($server, $user, $pass, $base);
        if ($conectar->connect_error) {
            die("Error de conexión: " . $conectar->connect_error);
        }
        $conectar->set_charset("utf8mb4");
        return $conectar;
    }

    public function usuarioExiste($nombreUsuario) {
        $sql = "SELECT id FROM usuario WHERE nombre_usuario = ?";
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
            return false;
        }
        $sql = "UPDATE usuario SET nombre_usuario = ? WHERE id = ?";
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
        $sql = "SELECT contrasena FROM usuario WHERE id = ?";
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
            // Corregido para usar password_verify con contraseña hasheada
            return password_verify($contrasena, $usuario['contrasena']);
        }
        return false;
    }

  public function cambiarContrasena($idUsuario, $nuevaContrasenaHasheada) {
    $sql = "UPDATE usuario SET contrasena = ? WHERE id = ?";
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
    $sql = "SELECT contrasena FROM usuario WHERE id = ?";
    $stmt = $this->conexion->prepare($sql);
    if (!$stmt) {
        die("Error en prepare obtenerHashContrasena: " . $this->conexion->error);
    }
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fila = $resultado->fetch_assoc();
    $stmt->close();
    return $fila ? $fila['contrasena'] : null;
}

    public function eliminarCuenta($idUsuario) {
        $sql = "DELETE FROM usuario WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare eliminarCuenta: " . $this->conexion->error);
        }
        $stmt->bind_param("i", $idUsuario);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    public function cerrarConexion() {
        $this->conexion->close();
    }
}
?>

