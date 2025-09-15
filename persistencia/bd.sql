-- Crea la base de datos si no existe y la selecciona para trabajar
CREATE DATABASE IF NOT EXISTS zappymenu;
USE zappymenu;

-- Tabla Grupo: agrupa usuarios (ej: admin, jugador, moderador)
CREATE TABLE Grupo (
    idGrupo INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nomGrupo VARCHAR(100) NOT NULL, -- Nombre del grupo
    tipoUsr VARCHAR(50) NOT NULL    -- Tipo de usuario asociado
) ENGINE=InnoDB;

-- Tabla Usuario: guarda la información de cada usuario
CREATE TABLE Usuario (
    idUsr INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom_usr VARCHAR(50) UNIQUE NOT NULL, -- Nombre de usuario único
    nom_real VARCHAR(100),               -- Nombre real (opcional)
    correo VARCHAR(100) UNIQUE NOT NULL, -- Correo único
    contrasena VARCHAR(255) NOT NULL,    -- Contraseña (encriptada)
    fecha_nac DATE,                      -- Fecha de nacimiento
    genero ENUM('M','F','Otro'),         -- Género
    idGrupo INT UNSIGNED,                -- Relación con Grupo
    FOREIGN KEY (idGrupo) REFERENCES Grupo(idGrupo)
) ENGINE=InnoDB;

-- Tabla Juego: almacena los distintos juegos
CREATE TABLE Juego (
    idJuego INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombreJuego VARCHAR(100) NOT NULL, -- Nombre del juego
    puntos INT DEFAULT 0               -- Puntos base o iniciales
) ENGINE=InnoDB;

-- Tabla Juega: relación N:M entre Usuario y Juego
-- Guarda historial de partidas y puntajes acumulados
CREATE TABLE Juega (
    idJuega INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUsr INT UNSIGNED NOT NULL,          -- Usuario que juega
    idJuego INT UNSIGNED NOT NULL,        -- Juego jugado
    fechaJugo DATETIME DEFAULT CURRENT_TIMESTAMP, -- Fecha/hora de la partida
    sumPuntos INT DEFAULT 0,              -- Puntos conseguidos
    FOREIGN KEY (idUsr) REFERENCES Usuario(idUsr) ON DELETE CASCADE,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Subtipos de Juego: cada tabla especializa a "Juego"
-- (1:1 con la tabla Juego, porque heredan de ella)

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

-- Subtipo de Juego específico: Trivia
CREATE TABLE Trivia (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Juego(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Subtipo de Trivia: TriviaHTML (ej: preguntas de programación web)
CREATE TABLE TriviaHTML (
    idJuego INT UNSIGNED PRIMARY KEY,
    FOREIGN KEY (idJuego) REFERENCES Trivia(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Subtipo de Trivia: TriviaMatematica (con campo adicional de dificultad)
CREATE TABLE TriviaMatematica (
    idJuego INT UNSIGNED PRIMARY KEY,
    dificultad VARCHAR(50), -- Nivel de dificultad de la trivia
    FOREIGN KEY (idJuego) REFERENCES Trivia(idJuego) ON DELETE CASCADE
) ENGINE=InnoDB;
