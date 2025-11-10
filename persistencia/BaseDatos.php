<?php
class BaseDatos {
    private $conexion;
    private $servidor = "localhost";
    private $usuario = "root";
    private $password = "";
    private $base_datos = "zappymenu"; // Base de datos

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
       MÉTODOS PARA GRUPOS
       ========================= */
    public function crearGrupo($nomGrupo, $descripcionGrupo, $fechaCreacion, $estadoGrupo, $tipoUsr) {
        $sql = "INSERT INTO Grupo (nomGrupo, descripcionGrupo, fechaCreacion, estadoGrupo, tipoUsr)
                VALUES (?, ?, ?, ?, ?)";
        return $this->ejecutar($sql, "sssss", $nomGrupo, $descripcionGrupo, $fechaCreacion, $estadoGrupo, $tipoUsr);
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

    public function actualizarGrupo($idGrupo, $nomGrupo, $descripcionGrupo, $estadoGrupo, $tipoUsr) {
        $sql = "UPDATE Grupo 
                SET nomGrupo = ?, descripcionGrupo = ?, estadoGrupo = ?, tipoUsr = ?
                WHERE idGrupo = ?";
        return $this->ejecutar($sql, "ssssi", $nomGrupo, $descripcionGrupo, $estadoGrupo, $tipoUsr, $idGrupo);
    }

    public function eliminarGrupo($idGrupo) {
        $sql = "DELETE FROM Grupo WHERE idGrupo = ?";
        return $this->ejecutar($sql, "i", $idGrupo);
    }

    /* =========================
       MÉTODOS PARA PUNTAJES
       ========================= */
    public function obtenerPuntajeTotalUsuario($idUsr, $idJuego = null) {
        if ($idJuego !== null) {
            $sql = "SELECT SUM(sumPuntos) AS totalPuntos FROM Juega WHERE idUsr = ? AND idJuego = ?";
            $resultado = $this->consultar($sql, "ii", $idUsr, $idJuego);
        } else {
            $sql = "SELECT SUM(sumPuntos) AS totalPuntos FROM Juega WHERE idUsr = ?";
            $resultado = $this->consultar($sql, "i", $idUsr);
        }
        return $resultado ? ($resultado[0]['totalPuntos'] ?? 0) : 0;
    }

    public function obtenerTopUsuarios($limite = 10) {
        $sql = "SELECT u.nom_usr, SUM(j.sumPuntos) AS totalPuntos
                FROM Usuario u
                LEFT JOIN Juega j ON u.idUsr = j.idUsr
                GROUP BY u.idUsr, u.nom_usr
                ORDER BY totalPuntos DESC
                LIMIT ?";
        return $this->consultar($sql, "i", $limite);
    }

    public function obtenerRankingUsuario($idUsr) {
        $sql = "SELECT COUNT(*) + 1 AS ranking
                FROM (
                    SELECT u.idUsr, SUM(j.sumPuntos) AS totalPuntos
                    FROM Usuario u
                    LEFT JOIN Juega j ON u.idUsr = j.idUsr
                    GROUP BY u.idUsr
                    HAVING SUM(j.sumPuntos) > (
                        SELECT SUM(j2.sumPuntos)
                        FROM Juega j2
                        WHERE j2.idUsr = ?
                    )
                ) AS superiores";
        $resultado = $this->consultar($sql, "i", $idUsr);
        return $resultado ? $resultado[0]['ranking'] : 1; // Si no hay superiores, es el primero
    }

    /* =========================
       CERRAR CONEXIÓN
       ========================= */
    public function cerrarConexion() {
        $this->conexion->close();
    }

    /* =========================
       OBTENER CONEXIÓN (nuevo)
       ========================= */
    public function getConexion() {
        return $this->conexion;
    }

    /* =========================
       Metodos para admin
       ========================= */
    public function esAdmin($idUsuario) {
        $sql = "SELECT esAdmin FROM Usuario WHERE idUsr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare esAdmin: " . $this->conexion->error);
        }
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        $stmt->close();

        return $usuario ? $usuario['esAdmin'] == 1 : false;
    }

    public function obtenerTodosLosUsuarios() {
    $sql = "SELECT idUsr, nom_usr, correo, activo, esAdmin FROM Usuario";
    $result = $this->conexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
    }

        /* =========================
       MÉTODOS NUEVOS PARA ADMIN Y ACTIVACIÓN
       ========================= */
    public function hacerAdmin($idUsuario) {
        $sql = "UPDATE Usuario SET esAdmin = 1 WHERE idUsr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare hacerAdmin: " . $this->conexion->error);
        }
        $stmt->bind_param("i", $idUsuario);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    public function cambiarEstadoUsuario($idUsuario, $activo) {
        $sql = "UPDATE Usuario SET activo = ? WHERE idUsr = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            die("Error en prepare cambiarEstadoUsuario: " . $this->conexion->error);
        }
        $stmt->bind_param("ii", $activo, $idUsuario);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

}
?>
