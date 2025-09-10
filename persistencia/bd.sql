-- Base de datos general
CREATE DATABASE IF NOT EXISTS zappyMenuDeJuegos;
USE zappyMenuDeJuegos;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre_usuario VARCHAR(20) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  nombre VARCHAR(30) NOT NULL,
  fecha_nacimiento DATE NOT NULL,
  email VARCHAR(50) NOT NULL,
  sexo ENUM('masculino','femenino','otro','prefiero_no_decirlo') NOT NULL,
  permisos ENUM('Administrador','Jugador') NOT NULL DEFAULT 'Jugador'
);

-- Tabla de juegos
CREATE TABLE IF NOT EXISTS juego (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(30) NOT NULL,
  tipo ENUM('memoria','trivia','azaroso','puertaslocas','piedra_papel_o_tijera') NOT NULL,
  recompensa VARCHAR(50) NOT NULL
);

-- Tabla de partidas (puntajes de cualquier juego)
CREATE TABLE IF NOT EXISTS partida (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_juego INT NOT NULL,
  puntaje INT NOT NULL,
  fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES usuario(id),
  FOREIGN KEY (id_juego) REFERENCES juego(id)
);
