CREATE DATABASE agenda_citas;
USE agenda_citas;

CREATE TABLE IF NOT EXISTS t_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    celular VARCHAR(20) NULL,
    clave VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS t_categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS t_servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cat INT NOT NULL,
    precio INT NOT NULL,
    id_duracion INT NOT NULL,
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS t_esteticistas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cat INT NOT NULL,
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS t_citas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_serv INT NOT NULL,
    id_cat INT NOT NULL,
    id_esteticista INT NOT NULL,
    email_cliente VARCHAR(150) NOT NULL,
    anio INT NOT NULL,
    mes INT NOT NULL,
    dia INT NOT NULL,
    hora INT NOT NULL,
    duracion INT NOT NULL,  -- Duración en minutos
    horafin INT NOT NULL,
    FOREIGN KEY (id_serv) REFERENCES t_servicios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id) ON DELETE CASCADE,
    FOREIGN KEY (id_esteticista) REFERENCES t_esteticistas(id) ON DELETE CASCADE,
    FOREIGN KEY (email_cliente) REFERENCES t_usuarios(email) ON DELETE CASCADE
);

-- Insertar categorías
INSERT INTO t_categorias (nombre) VALUES ('Uñas'), ('Cera'), ('Spa');

-- Insertar servicios
INSERT INTO t_servicios (nombre, id_cat, precio) VALUES
('Manicure', (SELECT id FROM t_categorias WHERE nombre = 'Uñas'), 25000, 1),
('Depilación facial', (SELECT id FROM t_categorias WHERE nombre = 'Cera'), 30000, 2),
('Masaje relajante', (SELECT id FROM t_categorias WHERE nombre = 'Spa'), 60000, 1);

-- Insertar esteticistas
INSERT INTO t_esteticistas (nombre, id_cat) VALUES
('Ana Pérez', (SELECT id FROM t_categorias WHERE nombre = 'Uñas')),
('Carlos Gómez', (SELECT id FROM t_categorias WHERE nombre = 'Cera')),
('Laura Fernández', (SELECT id FROM t_categorias WHERE nombre = 'Spa'));

