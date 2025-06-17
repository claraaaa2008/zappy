<?php
class BaseDatos {
    
    // Propiedades privadas para los datos de conexión
    private $servidor;      // Generalmente es "localhost" si estás usando XAMPP
    private $usuario;       // En XAMPP por defecto es "root"
    private $password;      // En XAMPP no suele tener contraseña, queda en blanco
    private $base_datos;    // Nombre de la base de datos a la que se va a conectar
    private $conexion;      // Variable que guarda la conexión activa

    // Constructor: se ejecuta automáticamente al crear el objeto
    public function __construct() {
        $this->servidor = "localhost";
        $this->usuario = "root";
        $this->password = "";
        $this->base_datos = "basedatos"; // Asegurate de que esta BD exista
        $this->conexion = $this->nueva($this->servidor, $this->usuario, $this->password, $this->base_datos);
    }

    // Función privada que establece la conexión con la base de datos
    private function nueva($server, $user, $pass, $base) {
        $conectar = mysqli_connect($server, $user, $pass, $base);
        if (!$conectar) {
            die("Error de conexión: " . mysqli_connect_error()); // Corta la ejecución si falla la conexión
        }
        return $conectar; // Devuelve la conexión si todo salió bien
    }

    // Devuelve un array de preguntas con sus opciones de respuesta
    public function traerPreguntasConRespuestas() {
        $sql = "SELECT p.id AS pregunta_id, p.texto AS pregunta, o.id AS opcion_id, o.texto AS opcion
                FROM preguntas p 
                JOIN opciones o ON p.id = o.pregunta_id
                ORDER BY p.id, o.id";

        $resultado = $this->conexion->query($sql);
        $preguntas = [];

        // Agrupa las opciones bajo su pregunta correspondiente
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

        return $preguntas; // Devuelve todo listo para mostrar en el frontend o usar en lógica
    }

    // Devuelve un array con las respuestas correctas, indexadas por pregunta
    public function respuestasCorrectas() {
        $sql = "SELECT pregunta_id, id AS opcion_id
                FROM opciones
                WHERE es_correcta = 1";

        $resultado = $this->conexion->query($sql);
        $respuestas_correctas = [];

        // Cada pregunta apunta a su opción correcta
        while ($fila = $resultado->fetch_assoc()) {
            $respuestas_correctas[$fila['pregunta_id']] = $fila['opcion_id'];
        }

        return $respuestas_correctas;
    }
}
?>
