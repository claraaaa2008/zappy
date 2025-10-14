<?php
class BaseDatos {
    private $conexion;
    private $servidor = "localhost";
    private $usuario = "root";
    private $password = "";
    private $base_datos = "zappymenu"; 

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

    // =========================
    // MÉTODOS GENÉRICOS
    // =========================
    public function ejecutar($sql, $tipos, ...$params) {
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) die("Error en prepare: " . $this->conexion->error);
        $stmt->bind_param($tipos, ...$params);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function consultar($sql, $tipos = "", ...$params) {
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) die("Error en prepare: " . $this->conexion->error);
        if ($tipos !== "") $stmt->bind_param($tipos, ...$params);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $filas = $resultado->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $filas;
    }

    // =========================
    // MÉTODOS PARA USUARIOS
    // =========================
    public function usuarioExiste($nombreUsuario) {
        $sql = "SELECT idUsr FROM Usuario WHERE nom_usr = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $nombreUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $existe = $result->num_rows > 0;
        $stmt->close();
        return $existe;
    }

    // =========================
    // MÉTODOS PARA GRUPOS
    // =========================
    public function crearGrupo($nomGrupo, $descripcion, $codigoGrupo, $tipoUsr, $idCreador) {
        $sql = "INSERT INTO Grupo (nomGrupo, descripcion, codigoGrupo, tipoUsr, idCreador)
                VALUES (?, ?, ?, ?, ?)";
        return $this->ejecutar($sql, "ssssi", $nomGrupo, $descripcion, $codigoGrupo, $tipoUsr, $idCreador);
    }

    public function obtenerGrupos() {
        $sql = "SELECT * FROM Grupo ORDER BY idGrupo DESC";
        return $this->consultar($sql);
    }

    public function obtenerGrupoPorId($idGrupo) {
        $sql = "SELECT * FROM Grupo WHERE idGrupo = ?";
        $resultado = $this->consultar($sql, "i", $idGrupo);
        return $resultado ? $resultado[0] : null;
    }

    public function actualizarGrupo($idGrupo, $nomGrupo, $descripcion, $tipoUsr) {
        $sql = "UPDATE Grupo SET nomGrupo = ?, descripcion = ?, tipoUsr = ? WHERE idGrupo = ?";
        return $this->ejecutar($sql, "sssi", $nomGrupo, $descripcion, $tipoUsr, $idGrupo);
    }

    public function eliminarGrupo($idGrupo) {
        $sql = "DELETE FROM Grupo WHERE idGrupo = ?";
        return $this->ejecutar($sql, "i", $idGrupo);
    }

    // =========================
    // CERRAR CONEXIÓN
    // =========================
    public function cerrarConexion() {
        $this->conexion->close();
    }
}
?>
