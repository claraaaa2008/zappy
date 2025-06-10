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

