-- Crear base de datos
CREATE DATABASE agenda_citas;

-- Conectarse a la base de datos (en psql)
\c agenda_citas;

-- Tabla de roles
CREATE TABLE IF NOT EXISTS t_roles (
    id SERIAL PRIMARY KEY,
    nombre_rol VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT NULL
);

-- Tabla de cuentas
CREATE TABLE IF NOT EXISTS t_cuentas (
    id SERIAL PRIMARY KEY,
    nombre_empresa VARCHAR NOT NULL,
    nit_rut VARCHAR NOT NULL -- NIT o RUT de la empresa o usuario que crea la cuenta
);

-- Tabla de clientes
CREATE TABLE IF NOT EXISTS t_usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    celular VARCHAR(20) NULL,
    clave VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    id_cuenta INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES t_roles(id) ON UPDATE CASCADE ON DELETE RESTRICT
    FOREIGN KEY (id_cuenta) REFERENCES t_cuentas(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS t_categorias (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cuenta INT NOT NULL,
    eliminado_en TIMESTAMP NULL, -- Para borrado logico y no fisico, para evitar alterar el registro de citas.
    FOREIGN KEY (id_cuenta) REFERENCES t_cuentas(id) ON DELETE CASCADE
);

-- Tabla de servicios
CREATE TABLE IF NOT EXISTS t_servicios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cat INT NOT NULL,
    precio INT NOT NULL,
    duracion INT NOT NULL, -- Duracion en horas
    id_cuenta INT NOT NULL,
    eliminado_en TIMESTAMP NULL, -- Para borrado logico y no fisico, para evitar alterar el registro de citas.
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id),
    FOREIGN KEY (id_cuenta) REFERENCES t_cuentas(id) ON DELETE CASCADE
);

-- Tabla de esteticistas
CREATE TABLE IF NOT EXISTS t_esteticistas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cat INT NOT NULL,
    id_cuenta INT NOT NULL,
    eliminado_en TIMESTAMP NULL, -- Para borrado logico y no fisico, para evitar alterar el registro de citas.
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id),
    FOREIGN KEY (id_cuenta) REFERENCES t_cuentas(id) ON DELETE CASCADE
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
    FOREIGN KEY (id_serv) REFERENCES t_servicios(id),
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id),
    FOREIGN KEY (id_esteticista) REFERENCES t_esteticistas(id),
    FOREIGN KEY (email_cliente) REFERENCES t_usuarios(email) ON UPDATE CASCADE
);

-- Datos de prueba para insertar en la base de datos (Opcional)

-- Insertar roles
INSERT INTO t_roles (nombre_rol, descripcion)
VALUES ('administrador', 'Puede configurar completamente la cuenta, crear, editar, eliminar esteticistas, categorias, etc.'), 
('cliente', 'Puede ver, editar y crear citas.');

-- Insertar cuenta
INSERT INTO t_cuentas (nombre_empresa, nit_rut)
VALUES ('Logística Express LTDA', '830.543.210-2');

-- Insertar categorías
INSERT INTO t_categorias (nombre, id_cuenta, eliminado_en)
VALUES ('Uñas', 1, NULL), ('Cera', 1, NULL), ('Spa', 1, NULL);

-- Insertar servicios (uno por uno con SELECT para referenciar id de categoría)
INSERT INTO t_servicios (nombre, id_cat, precio, id_duracion, id_cuenta, eliminado_en)
SELECT 'Manicure', id, 25000, 1, 1, NULL FROM t_categorias WHERE nombre = 'Uñas';

INSERT INTO t_servicios (nombre, id_cat, precio, id_duracion, id_cuenta, eliminado_en)
SELECT 'Depilación facial', id, 30000, 2, 1, NULL FROM t_categorias WHERE nombre = 'Cera';

INSERT INTO t_servicios (nombre, id_cat, precio, id_duracion, id_cuenta, eliminado_en)
SELECT 'Masaje relajante', id, 60000, 1, 1, NULL FROM t_categorias WHERE nombre = 'Spa';

-- Insertar esteticistas (también uno por uno con SELECT)
INSERT INTO t_esteticistas (nombre, id_cat, id_cuenta, eliminado_en)
SELECT 'Ana Pérez', id, 1, NULL FROM t_categorias WHERE nombre = 'Uñas';

INSERT INTO t_esteticistas (nombre, id_cat, id_cuenta, eliminado_en)
SELECT 'Carlos Gómez', id, 1, NULL FROM t_categorias WHERE nombre = 'Cera';

INSERT INTO t_esteticistas (nombre, id_cat, id_cuenta, eliminado_en)
SELECT 'Laura Fernández', id, 1, NULL FROM t_categorias WHERE nombre = 'Spa';
