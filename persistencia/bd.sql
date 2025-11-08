-- ==========================================================
-- CREAR BASE DE DATOS zappymenu
-- ==========================================================

CREATE DATABASE IF NOT EXISTS zappymenu;
USE zappymenu;

-- ==========================================================
-- ELIMINAR TABLAS SI YA EXISTEN (para evitar conflictos)
-- ==========================================================
DROP TABLE IF EXISTS Juega;
DROP TABLE IF EXISTS JuegoMosqueta;
DROP TABLE IF EXISTS Memoria;
DROP TABLE IF EXISTS JuegoPuertas;
DROP TABLE IF EXISTS PiedraPapelTijera;
DROP TABLE IF EXISTS TriviaHTML;
DROP TABLE IF EXISTS TriviaMatematica;
DROP TABLE IF EXISTS Trivia;
DROP TABLE IF EXISTS Juego;
DROP TABLE IF EXISTS Usuario;
DROP TABLE IF EXISTS Grupo;

-- ==========================================================
-- CREAR TABLAS BASE
-- ==========================================================

-- Tabla Grupo
CREATE TABLE Grupo (
    idGrupo INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nomGrupo VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    codigoGrupo VARCHAR(10) UNIQUE NOT NULL,
    idCreador INT UNSIGNED NOT NULL
) ENGINE=InnoDB;

-- Tabla Usuario
CREATE TABLE Usuario (
    idUsr INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom_usr VARCHAR(50) UNIQUE NOT NULL,
    nom_real VARCHAR(100),
    correo VARCHAR(100) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    fecha_nac DATE,
    genero ENUM('M','F','Otro'),
    idGrupo INT UNSIGNED,
    activo TINYINT(1) DEFAULT 1,
    esAdmin TINYINT(1) DEFAULT 0,
    fotoPerfil VARCHAR(255) DEFAULT 'default.png'
) ENGINE=InnoDB;

-- Tabla Juego
CREATE TABLE Juego (
    idJuego INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombreJuego VARCHAR(100) NOT NULL,
    puntos INT DEFAULT 0
) ENGINE=InnoDB;

-- ==========================================================
-- RELACIONES ENTRE TABLAS
-- ==========================================================

-- Relación Grupo → Usuario (creador del grupo)
ALTER TABLE Grupo 
    ADD CONSTRAINT fk_grupo_creador 
    FOREIGN KEY (idCreador) REFERENCES Usuario(idUsr) 
    ON DELETE CASCADE;

-- Relación Usuario → Grupo (pertenece a un grupo)
ALTER TABLE Usuario 
    ADD CONSTRAINT fk_usuario_grupo 
    FOREIGN KEY (idGrupo) REFERENCES Grupo(idGrupo);

-- ==========================================================
-- TABLA INTERMEDIA: USUARIO - JUEGO
-- ==========================================================
CREATE TABLE Juega (
    idJuega INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUsr INT UNSIGNED NOT NULL,
    idJuego INT UNSIGNED NOT NULL,
    fechaJugo DATETIME DEFAULT CURRENT_TIMESTAMP,
    sumPuntos INT DEFAULT 0,
    FOREIGN KEY (idUsr) REFERENCES Usuario(idUsr) ON DELETE CASCADE,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================================================
-- SUBTIPOS DE JUEGO
-- ==========================================================
CREATE TABLE JuegoMosqueta (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Memoria (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE JuegoPuertas (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE PiedraPapelTijera (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Trivia (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE TriviaHTML (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Trivia(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE TriviaMatematica (
    idJuego INT UNSIGNED PRIMARY KEY,
    dificultad VARCHAR(50),
    FOREIGN KEY (idJuego) REFERENCES Trivia(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ==========================================================
-- INSERTAR DATOS INICIALES
-- ==========================================================

-- Insertar juegos
INSERT INTO Juego (idJuego, nombreJuego, puntos) VALUES
(1, 'Memory', 0),
(2, 'Piedra Papel Tijera', 0),
(3, 'Trivia Matemática', 0),
(4, 'Monty Hall', 0),
(5, 'Juego de la Mosqueta', 0),
(6, 'Trivia HTML', 0);

-- Insertar subtipos de juegos
INSERT INTO Memoria (idJuego) VALUES (1);
INSERT INTO PiedraPapelTijera (idJuego) VALUES (2);
INSERT INTO Trivia (idJuego) VALUES (3), (6);
INSERT INTO JuegoPuertas (idJuego) VALUES (4);
INSERT INTO JuegoMosqueta (idJuego) VALUES (5);
INSERT INTO TriviaMatematica (idJuego, dificultad) VALUES (3, 'Fácil');
INSERT INTO TriviaHTML (idJuego) VALUES (6);
