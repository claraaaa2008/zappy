-- Creamos la base de datos solo si no existe todavía
CREATE DATABASE IF NOT EXISTS zappyMenuDeJuegos;

-- Usamos la base de datos que acabamos de crear
USE zappyMenuDeJuegos;

-- Por si ya existen, eliminamos las tablas para evitar conflictos
DROP TABLE IF EXISTS administrador;
DROP TABLE IF EXISTS juego;
DROP TABLE IF EXISTS usuario;

-- Creamos la tabla "administrador"
-- Aunque por ahora solo tiene un campo, puede usarse para manejar permisos especiales
CREATE TABLE administrador (
  permisos VARCHAR(13) DEFAULT NULL
);

-- Tabla para los distintos juegos disponibles
CREATE TABLE juego (
  id INT(11) NOT NULL PRIMARY KEY, -- ID único de cada juego
  nombre VARCHAR(30) NOT NULL,     -- Nombre del juego
  recompensa VARCHAR(50) NOT NULL, -- Qué gana el jugador al completar el juego
  tipo ENUM('memoria','trivia','azaroso','puertaslocas','piedra_papel_o_tijera') NOT NULL
  -- El tipo de juego (limitado a estas opciones)
);

-- Tabla para registrar los usuarios que se crean en la plataforma
CREATE TABLE usuario (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, -- ID único para cada usuario, se incrementa solo
  nombre_usuario VARCHAR(20) NOT NULL,            -- El nombre que usa para iniciar sesión
  contrasena VARCHAR(20) NOT NULL,                -- Su contraseña (sin tilde en el campo)
  nombre VARCHAR(30) NOT NULL,                    -- Su nombre real
  fecha_nacimiento DATE NOT NULL,                 -- Fecha de nacimiento
  email VARCHAR(50) NOT NULL,                     -- Correo electrónico
  sexo ENUM('masculino','femenino','otro','prefiero_no_decirlo') NOT NULL,
  -- Para que el usuario pueda elegir su identidad de género(cambiar a tres opciones, femenino, masculino o prefiero no decirlo)
  permisos ENUM('Administrador','Jugador') NOT NULL DEFAULT 'Jugador'
  -- El tipo de cuenta (por defecto será Jugador)
);

