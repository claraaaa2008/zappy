<?php
// Definimos una clase llamada BaseDatos para manejar toda la lógica de conexión y operaciones sobre la base de datos
class BaseDatos {

    // Variables privadas para guardar los datos de conexión
    private $servidor;
    private $usuario;
    private $password;
    private $base_datos;
    private $conexion;

    // Constructor: se ejecuta automáticamente cuando se crea una instancia de esta clase
    public function __construct() {
        $this->servidor = "localhost";             // Dirección del servidor (en este caso, el mismo equipo)
        $this->usuario = "root";                   // Usuario de la base de datos
        $this->password = "";                      // Contraseña del usuario (vacía en entornos locales)
        $this->base_datos = "zappyMenuDeJuegos";   // Nombre de la base de datos
        // Creamos la conexión usando los datos anteriores
        $this->conexion = $this->nuevaConexion($this->servidor, $this->usuario, $this->password, $this->base_datos);
    }

    // Método privado que se encarga de crear y devolver una nueva conexión con MySQL
    private function nuevaConexion($server, $user, $pass, $base) {
        $conectar = new mysqli($server, $user, $pass, $base);
        // Si hay un error al conectar, detenemos el programa y mostramos el error
        if ($conectar->connect_error) {
            die("Error de conexión: " . $conectar->connect_error);
        }
        // Aseguramos que los caracteres especiales (como acentos y ñ) se manejen correctamente
        $conectar->set_charset("utf8mb4");
        return $conectar;
    }

    // Verifica si un nombre de usuario ya existe en la base de datos
    public function usuarioExiste($nombreUsuario) {
        $sql = "SELECT id FROM usuario WHERE nombre_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare usuarioExiste: " . $this->conexion->error);
        }
        // Reemplazamos el signo ? por el nombre de usuario
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $existe = $result->num_rows > 0;  // Si hay al menos una fila, significa que ya existe
        $stmt->close();
        return $existe;
    }

    // Cambia el nombre de usuario, pero solo si el nuevo no está en uso
    public function cambiarNombreUsuario($idUsuario, $nuevoUsuario) {
        if ($this->usuarioExiste($nuevoUsuario)) {
            return false; // Si ya existe, no lo cambiamos
        }
        $sql = "UPDATE usuario SET nombre_usuario = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare cambiarNombreUsuario: " . $this->conexion->error);
        }
        $stmt->bind_param("si", $nuevoUsuario, $idUsuario); // s: string, i: integer
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado; // true si se actualizó bien, false si falló
    }

    // Verifica si la contraseña ingresada coincide con la del usuario
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
            // Comparación directa (sin hashing). Si estuviera cifrada, se usaría password_verify
            return $usuario['contrasena'] === $contrasena;
        }
        return false; // Si no se encuentra el usuario
    }

    // Cambia la contraseña del usuario
    public function cambiarContrasena($idUsuario, $nuevaContrasena) {
        $sql = "UPDATE usuario SET contrasena = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare cambiarContrasena: " . $this->conexion->error);
        }
        $stmt->bind_param("si", $nuevaContrasena, $idUsuario);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    // Elimina un usuario por completo de la base de datos
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

    // Cierra la conexión cuando ya no se necesita
    public function cerrarConexion() {
        $this->conexion->close();
    }
}
?>
