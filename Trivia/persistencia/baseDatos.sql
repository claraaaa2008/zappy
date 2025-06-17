-- Crear la base de datos
CREATE DATABASE basedatos;
USE basedatos;

-- Crear tabla de preguntas
CREATE TABLE  preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL
);

-- Crear tabla de opciones
CREATE TABLE opciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_id INT NOT NULL,
    texto TEXT NOT NULL,
    es_correcta BOOLEAN DEFAULT 0,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id)
);

-- Insertar preguntas
INSERT INTO preguntas (texto) VALUES
('¿Cuál etiqueta se utiliza para crear un enlace en HTML?'),
('¿Qué etiqueta define un párrafo en HTML?'),
('¿Cuál etiqueta se usa para insertar una imagen?'),
('¿Qué atributo se usa para especificar el nombre de la imagen en la etiqueta <img>?'),
(' ¿Qué elemento HTML se utiliza para crear una tabla?'),
('¿Cuál es la etiqueta HTML para crear una celda en una tabla? '),
('¿Qué etiqueta HTML se usa para definir la sección de encabezado de un documento? '),
(' ¿Qué etiqueta HTML se usa para crear una lista numerada?'),
('¿Cuál es el elemento HTML que define un título principal de la página?'),
('¿Qué significa HTML?');

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
(3, '<pic>', 0),

(4, 'src', 0),
(4, 'alt', 1),
(4, 'title', 0),
(4, 'href', 0),

(5, '<table>', 1),
(5, '<tr>', 0),
(5, '<td>', 0),
(5, '<th>', 0),

(6, '<article>', 0),
(6, '<head>', 0),
(6, '<footer>', 0),
(6, '<header>', 1),

(7, '<ol>', 1),
(7, '<ul>', 0),
(7, '<li>', 0),
(7, '<dl>', 0),

(8, '<p>', 0),
(8, '<h2>', 0),
(8, '<h1>', 1),
(8, '<head>', 0),

(9, 'Hipertexto y Lenguaaje de Marcas', 0),
(9, 'Hipertexto y Lenguaje de Marcado', 1),
(9, 'Lenguaje de Hipertexto de Marcas', 0),
(9, 'Hipertexto y Marcado', 0);














