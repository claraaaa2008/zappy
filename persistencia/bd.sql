-- Creamos la base de datos solo si no existe todavía
CREATE DATABASE IF NOT EXISTS zappyMenuDeJuegos;

-- Usamos la base de datos que acabamos de crear
USE zappyMenuDeJuegos;

-- Por si ya existen, eliminamos las tablas para evitar conflictos
DROP TABLE IF EXISTS administrador;
DROP TABLE IF EXISTS juego;
DROP TABLE IF EXISTS usuario;

-- Tabla administrador
CREATE TABLE administrador (
  permisos VARCHAR(13) DEFAULT NULL
);

-- Tabla juego
CREATE TABLE juego (
  id INT(11) NOT NULL PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  recompensa VARCHAR(50) NOT NULL,
  tipo ENUM('memoria','trivia','azaroso','puertaslocas','piedra_papel_o_tijera') NOT NULL
);

-- Tabla usuario (actualizada)
CREATE TABLE usuario (
  id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_usuario VARCHAR(20) NOT NULL,
  contrasena VARCHAR(255) NOT NULL, -- 255 para almacenar hashes seguros
  nombre VARCHAR(30) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  email VARCHAR(50) NOT NULL,
  verificado TINYINT(1) NOT NULL DEFAULT 0,
  token_verificacion VARCHAR(64) DEFAULT NULL,
  sexo ENUM('masculino','femenino','otro','prefiero_no_decirlo') NOT NULL,
  permisos ENUM('Administrador','Jugador') NOT NULL DEFAULT 'Jugador'
);

