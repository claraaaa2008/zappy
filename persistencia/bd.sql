CREATE DATABASE zappyMenuDeJuegos;
USE zappyMenuDeJuegos;

CREATE TABLE administrador (
  permisos varchar(13) DEFAULT NULL
);

CREATE TABLE juego (
  id int(11) NOT NULL PRIMARY KEY,
  nombre varchar(30) NOT NULL,
  recompensa varchar(50) NOT NULL,
  tipo enum('memoria','trivia','azaroso','puertaslocas','piedra_papel_o_tijera') NOT NULL
);

CREATE TABLE usuario (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nombre_usuario varchar(20) NOT NULL,
  contraseña varchar(20) NOT NULL,
  nombre varchar(30) NOT NULL,
  fecha_nacimiento date NOT NULL,
  email varchar(50) NOT NULL,
  sexo enum('Masculino','Femenino','Otro') NOT NULL,
  permisos enum('Administrador','Jugador') NOT NULL
);

USE zappyMenuDeJuegos;
DELETE TABLE IF EXISTS usuario;