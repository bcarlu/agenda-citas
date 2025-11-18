-- Crear base de datos
CREATE DATABASE agenda_citas;

-- Conectarse a la base de datos (en psql)
\c agenda_citas;

-- Tabla de clientes
CREATE TABLE IF NOT EXISTS t_clientes (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    celular VARCHAR(20) NULL,
    clave VARCHAR(255) NOT NULL
);

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS t_categorias (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla de servicios
CREATE TABLE IF NOT EXISTS t_servicios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cat INT NOT NULL,
    precio INT NOT NULL,
    duracion INT NOT NULL, -- Duracion en horas
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id) ON DELETE CASCADE
);

-- Tabla de esteticistas
CREATE TABLE IF NOT EXISTS t_esteticistas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cat INT NOT NULL,
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id) ON DELETE CASCADE
);

-- Tabla de citas
CREATE TABLE IF NOT EXISTS t_citas (
    id SERIAL PRIMARY KEY,
    id_serv INT NOT NULL,
    id_cat INT NOT NULL,
    id_esteticista INT NOT NULL,
    email_cliente VARCHAR(150) NOT NULL,
    anio INT NOT NULL,
    mes INT NOT NULL,
    dia INT NOT NULL,
    hora INT NOT NULL,
    duracion INT NOT NULL,
    horafin INT NOT NULL,
    FOREIGN KEY (id_serv) REFERENCES t_servicios(id) ON DELETE CASCADE,
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id) ON DELETE CASCADE,
    FOREIGN KEY (id_esteticista) REFERENCES t_esteticistas(id) ON DELETE CASCADE,
    FOREIGN KEY (email_cliente) REFERENCES t_clientes(email) ON DELETE CASCADE
);

-- Insertar categorías
INSERT INTO t_categorias (nombre)
VALUES ('Uñas'), ('Cera'), ('Spa');

-- Insertar servicios (uno por uno con SELECT para referenciar id de categoría)
INSERT INTO t_servicios (nombre, id_cat, precio, id_duracion)
SELECT 'Manicure', id, 25000, 1 FROM t_categorias WHERE nombre = 'Uñas';

INSERT INTO t_servicios (nombre, id_cat, precio, id_duracion)
SELECT 'Depilación facial', id, 30000, 2 FROM t_categorias WHERE nombre = 'Cera';

INSERT INTO t_servicios (nombre, id_cat, precio, id_duracion)
SELECT 'Masaje relajante', id, 60000, 1 FROM t_categorias WHERE nombre = 'Spa';

-- Insertar esteticistas (también uno por uno con SELECT)
INSERT INTO t_esteticistas (nombre, id_cat)
SELECT 'Ana Pérez', id FROM t_categorias WHERE nombre = 'Uñas';

INSERT INTO t_esteticistas (nombre, id_cat)
SELECT 'Carlos Gómez', id FROM t_categorias WHERE nombre = 'Cera';

INSERT INTO t_esteticistas (nombre, id_cat)
SELECT 'Laura Fernández', id FROM t_categorias WHERE nombre = 'Spa';
