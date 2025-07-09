# Explicación del código de trivia
En este documento se explica cómo funcionan los diferentes archivos del sistema de trivia y cómo se conectan entre sí.

## basedatos.sql
Este archivo contiene la estructura de la base de datos utilizada por el sistema de trivia. Aquí se guardan los valores que se ingresan por el usuario y las preguntas con sus respectivas respuestas.

### Tablas:
- **preguntas**: Contiene las preguntas de trivia, cada una con su texto y la respuesta correcta.
    - `id`: Identificador único de la pregunta.
    - `texto`: Texto de la pregunta.

- **opciones**: Guarda las respuestas posibles para cada pregunta, incluyendo la respuesta correcta y las incorrectas. Esta será útil para guardar las respuestas marcadas por el usuario.
    - `id`: Identificador único de la opción.
    - `pregunta_id`: Referencia a la pregunta a la que pertenece esta opción.
    - `texto`: Texto de la opción.
    - `es_correcta`: Indica si esta opción es la respuesta correcta (booleano).
    - `FOREIGN KEY (pregunta_id) REFERENCES preguntas(id)`: Establece una relación entre las opciones y las preguntas.

### Insertar valores dentro de tablas
Para insertar valores en las tablas, se utilizan sentencias `INSERT INTO`. Por ejemplo, para agregar una pregunta y sus opciones:

~~~sql
-- Insertar preguntas
INSERT INTO preguntas (texto) VALUES
('¿Cuál etiqueta se utiliza para crear un enlace en HTML?'),
('¿Qué etiqueta define un párrafo en HTML?'),
('¿Cuál etiqueta se usa para insertar una imagen?');

-- Insertar opciones
INSERT INTO opciones (pregunta_id, texto, es_correcta) VALUES
-- Pregunta 1
(1, '<div>', 0),
(1, '<link>', 0),
(1, '<a>', 1),
(1, '<href>', 0),
-- Pregunta 2
(2, '<h1>', 0),
(2, '<p>', 1),
(2, '<text>', 0),
(2, '<paragraph>', 0),
-- Pregunta 3
(3, '<image>', 0),
(3, '<img>', 1),
(3, '<src>', 0),
(3, '<pic>', 0);
~~~

*Nota*: `es_correcta` es un valor booleano, es decir que para indicar si es correcto o incorrecto, se debe poner 0 (incorrecto) o 1 (correcto).

## BaseDatos.php
Este archivo funciona como intermediario entre la base de datos y el front-end (`trivia.html.php`). Aquí se realizan las consultas a la base de datos para obtener las preguntas y opciones, así como para insertar las respuestas del usuario.

### Clase BaseDatos
Es la clase que maneja la conexión a la base de datos y las consultas.

- Variables dentro de `BaseDatos`
~~~php
private $servidor;
private $usuario;
private $password;
private $basedatos;
private $conexion;
~~~
### Métodos de la clase BaseDatos
#### `__construct()`:
___
Constructor que establece la conexión a la base de datos utilizando los parámetros definidos: `localhost`, `root`, `""` y `basedatos`. En la última línea une todos estos parámetros establecidos en `$this->conexion`.

#### `nueva($server, $user, $pass, $base)`:
___
Esta función se ejecuta automáticamente al crear una instancia de la clase `BaseDatos`.

~~~php
private function nueva($server, $user, $pass, $base) {
    $conectar = mysqli_connect($server, $user, $pass, $base);
    if (!$conectar) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    return $conectar;
}
~~~

- `$conectar`: Es una variable que almacena la conexión a la base de datos. Si la conexión falla, se muestra un mensaje de error y se detiene la ejecución del script.

#### `traerPreguntasConRespuestas()`:
___
Este método de tipo array realiza una consulta a la base de datos para obtener todas las preguntas y sus respectivas opciones de respuesta.

- `fetch_assoc()` sirve para obtener un array asociativo de los resultados de la consulta, donde las claves son los nombres de las columnas de la tabla.
~~~php
    while ($fila = $resultado->fetch_assoc()) {
        // Resto del código ...
    }
~~~

#### `respuestasCorrectas()`:
___
Este método recibe un array de respuestas del usuario y verifica cuáles son correctas consultando la base de datos. Retorna un array con las respuestas correctas.

## trivia.html.php
Este archivo es la interfaz de usuario de la trivia. Aquí se mostrarán las preguntas junto con sus respuestas y se procesarán las respuestas del usuario.

___
### Traer la base de datos
Lo primero es llamar al archivo `BaseDatos.php` para poder utilizar la clase `BaseDatos` y sus métodos.
- `require_once 'BaseDatos.php';`: Incluye el archivo de la clase `BaseDatos` para poder usarla en este script.

- `$traerBD = new BaseDatos();`: Crea una nueva instancia de la clase `BaseDatos`, lo que establece la conexión a la base de datos.

- `$preguntas = $traerBD->traerPreguntasConRespuestas();`: Llama al método para traer la pregunta con sus respuestas desde la base de datos.

- `$respuestasCorrectas = $traerBD->respuestasCorrectas($respuestasUsuario);`: Llama al método para verificar las respuestas del usuario y obtener las correctas.
  - `$respuestasUsuario`: Es un array que contiene las respuestas seleccionadas por el usuario. Este array se obtiene del formulario enviado por el usuario.
  
#### Variables para el puntaje:
- `$puntos`: Es una variable que almacena la cantidad de respuestas correctas del usuario. Se calcula contando el número de respuestas correctas en el array `$respuestasCorrectas`.
- `$total`: Cuenta el número de respuestas correctas en el array `$respuestasCorrectas`.

#### Logica de navegación y respuestas:
- `$preguntaActual`: Es un contador que se incrementa para cada pregunta mostrada en la interfaz. Se utiliza para mostrar el número de pregunta actual al usuario.
- `foreach ($preguntas as $pid => $datos)`: Si el usuario ha enviado una respuesta para esa pregunta, la guardamos en el array.
  - `$clave = "respuesta_" . $pid;`: Crea una clave única para cada pregunta basada en su ID, que se usará para almacenar la respuesta del usuario.
  - `if (isset($_POST[$clave]))`: Verifica si el usuario ha seleccionado una respuesta para esa pregunta.
  - `if (isset($_POST[$clave]))`: Si el usuario ha enviado una respuesta, se guarda en el array `$respuestasUsuario` con la clave correspondiente.
    - `$respuestasUsuario[$pid] = $_POST[$clave];`: Guarda la respuesta del usuario en el array `$respuestasUsuario` usando el ID de la pregunta como clave.
- `if (isset($_POST['anterior']))`: Si el usuario ha hecho clic en el botón "Anterior", se decrementa el contador de la pregunta actual, retrocediendo hacia la pregunta anterior.
- `if (isset($_POST['siguiente']))`: Si el usuario ha hecho clic en el botón "Siguiente", se incrementa el contador de la pregunta actual, avanzando hacia la siguiente pregunta.
- `$clavePreguntas = array_keys($preguntas);`: Obtiene las claves de las preguntas para poder navegar entre ellas.
- `$pidActual = $clavePreguntas[$preguntaActual];`: Obtiene el ID de la pregunta actual para mostrarla en la interfaz.

### Interfaz HTML de trivia.html.php
---
La parte HTML de `trivia.html.php` es la encargada de mostrar la interfaz de usuario de la trivia, permitiendo al usuario ver las preguntas, seleccionar respuestas y navegar entre ellas. A continuación se explica cada sección relevante:

#### 1. Estructura general
El archivo comienza con la declaración estándar de HTML e incluyendo los metadatos necesarios, como el charset y el título de la página.

También se incluye el archivo de estilos CSS con un parámetro de versión para evitar problemas de caché:

~~~html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuestionario De Html</title>
    <link rel="stylesheet" href="css/Estilos.css?v=<?= time() ?>">
</head>
~~~

#### 2. Contenedor del título y resultado
Dentro del `<body>`, se encuentra un `<div class="tituloContainer">` que contiene el título principal de la trivia y la imagen de Zappy. Además, si el usuario ya ha enviado el formulario, se muestra el resultado obtenido (puntaje sobre el total de preguntas) y, si corresponde, un mensaje de felicitación:

~~~html
<div class="tituloContainer">
    <h1 class="titulo">Cuestionario De Html</h1>
    <img src="imagenes/ZappyConCara.png" alt="TV personaje" class="zappy">
    <?php
        // Cálculo y muestra del puntaje y mensaje de felicitación (ver sección PHP)
    ?>
</div>
~~~

#### 3. Formulario principal de la trivia

El formulario utiliza el método POST para enviar los datos dentro del mismo archivo y tiene la clase `quote` para los estilos. Dentro del formulario:

- Se incluye un `<input type="hidden" name="preguntaActual" value="<?= $preguntaActual ?>">` para mantener el índice de la pregunta actual entre envíos.
- Se generan dinámicamente campos ocultos para cada respuesta seleccionada por el usuario, permitiendo que se mantengan al navegar entre preguntas:

~~~html
<form method="POST" class="quote">
    <input type="hidden" name="preguntaActual" value="<?= $preguntaActual ?>">
    <?php foreach ($respuestasUsuario as $pid => $rid): ?>
        <input type="hidden" name="respuesta_<?= $pid ?>" value="<?= $rid ?>">
    <?php endforeach; ?>
    ...
</form>
~~~

#### 4. Pregunta y opciones
Dentro del formulario, se muestra la pregunta actual y sus opciones de respuesta. Cada opción se presenta como un radio button dentro de un `<label class="opcion">`, lo que permite que el usuario seleccione solo una respuesta por pregunta. El texto de la pregunta y de cada opción se obtiene dinámicamente desde la base de datos:

~~~html
<div class="pregunta">
    <p><?= htmlspecialchars($preguntas[$pidActual]['pregunta']) ?></p>
    <?php foreach ($preguntas[$pidActual]['opciones'] as $opcion): ?>
        <label class="opcion">
            <input type="radio" name="respuesta_<?= $pidActual ?>" value="<?= $opcion['id'] ?>"
                <?= (isset($respuestasUsuario[$pidActual]) && $respuestasUsuario[$pidActual] == $opcion['id']) ? 'checked' : '' ?>>
            <?= htmlspecialchars($opcion['texto']) ?>
        </label><br>
    <?php endforeach; ?>
</div>
~~~

#### 5. Navegación entre preguntas
Al final del formulario, se encuentran los botones de navegación. Estos permiten al usuario avanzar o retroceder entre preguntas, y enviar el cuestionario al llegar a la última pregunta. La disposición de los botones se gestiona con un contenedor flex para mantener la alineación:

~~~html
<div style="display:flex; justify-content: space-between;">
    <?php if ($preguntaActual > 0): ?>
        <button type="submit" name="anterior" class="botonNav">&lt;</button>
    <?php else: ?>
        <div style="width:2.5rem"></div>
    <?php endif; ?>

    <?php if ($preguntaActual < $total - 1): ?>
        <button type="submit" name="siguiente" class="botonNav">&gt;</button>
    <?php endif; ?>

    <?php if ($preguntaActual == $total - 1): ?>
        <button type="submit" name="enviar" class="boton">Terminar</button>
    <?php endif; ?>
</div>
~~~

- El botón "anterior" solo aparece si no es la primera pregunta.
- El botón "siguiente" solo aparece si no es la última pregunta.
- El botón "Terminar" solo aparece en la última pregunta.

**En resumen:**  
La parte HTML de `trivia.html.php` está diseñada para ser dinámica y responsiva, mostrando una pregunta a la vez, permitiendo la navegación entre ellas y gestionando el envío y visualización de resultados de manera clara y ordenada.
