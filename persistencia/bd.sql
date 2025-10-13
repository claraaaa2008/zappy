-- ==========================================================
-- CREAR BASE DE DATOS zappymenu
-- ==========================================================

CREATE DATABASE IF NOT EXISTS zappymenu;
USE zappymenu;

-- Tabla Grupo
DROP TABLE IF EXISTS Grupo;

-- Crear tabla Grupo actualizada
CREATE TABLE Grupo (
    idGrupo INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nomGrupo VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    codigoGrupo VARCHAR(10) UNIQUE NOT NULL,
    tipoUsr VARCHAR(50) NOT NULL,
    idCreador INT UNSIGNED NOT NULL,
    FOREIGN KEY (idCreador) REFERENCES Usuario(idUsr) ON DELETE CASCADE
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
    FOREIGN KEY (idGrupo) REFERENCES Grupo(idGrupo)
) ENGINE=InnoDB;

-- Tabla Juego
CREATE TABLE Juego (
    idJuego INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombreJuego VARCHAR(100) NOT NULL,
    puntos INT DEFAULT 0
) ENGINE=InnoDB;

-- Relación Usuario-Juego (Juega)
CREATE TABLE Juega (
    idJuega INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUsr INT UNSIGNED NOT NULL,
    idJuego INT UNSIGNED NOT NULL,
    fechaJugo DATETIME DEFAULT CURRENT_TIMESTAMP,
    sumPuntos INT DEFAULT 0,
    FOREIGN KEY (idUsr) REFERENCES Usuario(idUsr) ON DELETE CASCADE,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Subtipos de Juego
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

-- Tabla Trivia (subtipo de Juego)
CREATE TABLE Trivia (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Subtipo TriviaHTML
CREATE TABLE TriviaHTML (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Trivia(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Subtipo TriviaMatematica
CREATE TABLE TriviaMatematica (
    idJuego INT UNSIGNED PRIMARY KEY,
    dificultad VARCHAR(50),
    FOREIGN KEY (idJuego) REFERENCES Trivia(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;