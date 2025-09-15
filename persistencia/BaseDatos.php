<?php
class BaseDatos {

    // Atributos privados para los datos de conexión y la propia conexión
    private $servidor;
    private $usuario;
    private $password;
    private $base_datos;
    private $conexion;

    // Constructor: inicializa los valores y crea la conexión a la base de datos
    public function __construct() {
        $this->servidor = "localhost";       // Servidor de la BD
        $this->usuario = "root";             // Usuario de la BD
        $this->password = "";                // Contraseña (vacía en este caso)
        $this->base_datos = "zappymenu";     // Nombre de la base de datos
        $this->conexion = $this->nuevaConexion(
            $this->servidor, 
            $this->usuario, 
            $this->password, 
            $this->base_datos
        );
    }

    // Crea una nueva conexión con MySQL usando mysqli
    private function nuevaConexion($server, $user, $pass, $base) {
        $conectar = new mysqli($server, $user, $pass, $base);
        if ($conectar->connect_error) {
            die("Error de conexión: " . $conectar->connect_error); // Termina si falla
        }
        $conectar->set_charset("utf8mb4"); // Configura charset para evitar problemas con acentos
        return $conectar;
    }

    // Verifica si existe un usuario en la tabla `Usuario` por su nombre
    public function usuarioExiste($nombreUsuario) {
        $sql = "SELECT idUsr FROM Usuario WHERE nom_usr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare usuarioExiste: " . $this->conexion->error);
        }
        $stmt->bind_param("s", $nombreUsuario); // "s" = string
        $stmt->execute();
        $result = $stmt->get_result();
        $existe = $result->num_rows > 0; // Devuelve true si encontró al menos un registro
        $stmt->close();
        return $existe;
    }

    // Cambia el nombre de usuario (si el nuevo nombre no está ocupado)
    public function cambiarNombreUsuario($idUsuario, $nuevoUsuario) {
        if ($this->usuarioExiste($nuevoUsuario)) {
            return false; // Si ya existe ese nombre, no lo cambia
        }
        $sql = "UPDATE Usuario SET nom_usr = ? WHERE idUsr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare cambiarNombreUsuario: " . $this->conexion->error);
        }
        $stmt->bind_param("si", $nuevoUsuario, $idUsuario); // "s" = string, "i" = integer
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado; // Devuelve true si la actualización fue exitosa
    }

    // Verifica si la contraseña ingresada coincide con la almacenada en la BD
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
            // Se usa password_verify para comparar el hash almacenado con la contraseña ingresada
            return password_verify($contrasena, $usuario['contrasena']);
        }
        return false;
    }

    // Cambia la contraseña de un usuario (la contraseña debe llegar ya hasheada con password_hash)
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

    // Obtiene el hash de la contraseña de un usuario (se usa internamente si lo necesitás)
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

    // Elimina un usuario de la tabla `Usuario`
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

    // Cierra la conexión con la base de datos
    public function cerrarConexion() {
        $this->conexion->close();
    }

    // Devuelve la conexión activa (por si se necesita usar directamente)
    public function getConexion() {
        return $this->conexion;
    }
}
?>
