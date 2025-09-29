<?php
class BaseDatos
{
    private $servidor;      // En Xampp es "localhost"
    private $usuario;       // En Xampp es "root"
    private $password;      // En Xampp es ""
    private $base_datos;
    private $conexion;

    public function __construct()
    {
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->password = "";
        $this->base_datos = "basedatos";
        $this->conexion = $this->nueva($this->servidor, $this->usuario, $this->password, $this->base_datos);
    }

    private function nueva($server, $user, $pass, $base)
    {
        $conectar = mysqli_connect($server, $user, $pass, $base);
        if (!$conectar) {
            die("Error de conexión: " . mysqli_connect_error());
        }
        return $conectar;
    }

    public function traerPreguntasConRespuestas()
    {
        $sql = "SELECT p.id AS pregunta_id, p.texto AS pregunta, o.id AS opcion_id, o.texto AS opcion
                FROM preguntas p 
                JOIN opciones o ON p.id = o.pregunta_id
                ORDER BY p.id, o.id";

        $resultado = $this->conexion->query($sql);
        $preguntas = [];

        while ($fila = $resultado->fetch_assoc()) {
            $pid = $fila['pregunta_id'];
            if (!isset($preguntas[$pid])) {
                $preguntas[$pid] = [
                    'pregunta' => $fila['pregunta'],
                    'opciones' => []
                ];
            }
            $preguntas[$pid]['opciones'][] = [
                'id' => $fila['opcion_id'],
                'texto' => $fila['opcion']
            ];
        }

        return $preguntas;
    }

    public function respuestasCorrectas()
    {
        $sql = "SELECT pregunta_id, id AS opcion_id
                FROM opciones
                WHERE es_correcta = 1";

        $resultado = $this->conexion->query($sql);
        $respuestas_correctas = [];

        while ($fila = $resultado->fetch_assoc()) {
            $respuestas_correctas[$fila['pregunta_id']] = $fila['opcion_id'];
        }

        return $respuestas_correctas;
    }
}
