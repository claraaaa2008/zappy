<?php
class BaseDatos {
    public $conexion;
    private $servidor = "localhost";
    private $usuario = "root";
    private $password = "";
    private $base_datos = "zappyMenuDeJuegos";

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

    public function cerrarConexion() {
        $this->conexion->close();
    }
}
?>