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

-- Tabla estados. Para estados de citas, esteticistas, servicios, categorias, cuentas. Tambien sirve para borrado logico de registros cuando sea necesario.
CREATE TABLE IF NOT EXISTS t_estados (
    id SERIAL PRIMARY KEY, -- 1 activo, 2 inactivo, 3 eliminado, 4 cancelado
    nombre VARCHAR NOT NULL
);

-- Tabla de cuentas
CREATE TABLE IF NOT EXISTS t_cuentas (
    id SERIAL PRIMARY KEY,
    nombre_empresa VARCHAR NOT NULL,
    nit_rut VARCHAR NOT NULL, -- NIT o RUT de la empresa o usuario que crea la cuenta
    uuid VARCHAR UNIQUE NULL, -- Id cuenta para uso en el registro de los usuarios (cliente)
    id_estado INT NOT NULL DEFAULT 1,
    creado_en TIMESTAMP WITH TIME ZONE NULL DEFAULT NOW(),
    actualizado_en TIMESTAMP WITH TIME ZONE WITH TIME ZONE NULL,
    FOREIGN KEY (id_estado) REFERENCES t_estados(id) ON UPDATE CASCADE
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
    id_estado INT NOT NULL DEFAULT 1, -- Para borrado logico, esto evita alterar los registros en t_citas.
    creado_en TIMESTAMP WITH TIME ZONE NULL DEFAULT NOW(),
    actualizado_en TIMESTAMP WITH TIME ZONE NULL,
    FOREIGN KEY (id_rol) REFERENCES t_roles(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (id_cuenta) REFERENCES t_cuentas(id) ON UPDATE CASCADE ON DELETE RESTRICT,
    FOREIGN KEY (id_estado) REFERENCES t_estados(id) ON UPDATE CASCADE
);

-- Tabla de categorías
CREATE TABLE IF NOT EXISTS t_categorias (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cuenta INT NOT NULL,
    id_estado INT NOT NULL DEFAULT 1,
    creado_en TIMESTAMP WITH TIME ZONE NULL DEFAULT NOW(),
    actualizado_en TIMESTAMP WITH TIME ZONE NULL,
    FOREIGN KEY (id_cuenta) REFERENCES t_cuentas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_estado) REFERENCES t_estados(id) ON UPDATE CASCADE
);

-- Tabla de servicios
CREATE TABLE IF NOT EXISTS t_servicios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cat INT NOT NULL,
    precio INT NOT NULL,
    duracion INT NOT NULL, -- Duracion en horas
    id_cuenta INT NOT NULL,
    id_estado INT NOT NULL DEFAULT 1,
    creado_en TIMESTAMP WITH TIME ZONE NULL DEFAULT NOW(),
    actualizado_en TIMESTAMP WITH TIME ZONE NULL,
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id),
    FOREIGN KEY (id_cuenta) REFERENCES t_cuentas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_estado) REFERENCES t_estados(id) ON UPDATE CASCADE
);

-- Tabla de esteticistas
CREATE TABLE IF NOT EXISTS t_esteticistas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_cat INT NOT NULL,
    id_cuenta INT NOT NULL,
    id_estado INT NOT NULL DEFAULT 1,
    creado_en TIMESTAMP WITH TIME ZONE NULL DEFAULT NOW(),
    actualizado_en TIMESTAMP WITH TIME ZONE NULL,
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id),
    FOREIGN KEY (id_cuenta) REFERENCES t_cuentas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_estado) REFERENCES t_estados(id) ON UPDATE CASCADE
);

-- Tabla de citas
CREATE TABLE IF NOT EXISTS t_citas (
    id SERIAL PRIMARY KEY,
    id_serv INT NOT NULL,
    id_cat INT NOT NULL,
    id_esteticista INT NOT NULL,
    id_usuario INT NOT NULL,
    anio INT NOT NULL,
    mes INT NOT NULL,
    dia INT NOT NULL,
    hora INT NOT NULL,
    duracion INT NOT NULL,
    horafin INT NOT NULL,
    id_estado INT NOT NULL DEFAULT 1,
    creado_en TIMESTAMP WITH TIME ZONE NULL DEFAULT NOW(),
    actualizado_en TIMESTAMP WITH TIME ZONE NULL,
    FOREIGN KEY (id_serv) REFERENCES t_servicios(id),
    FOREIGN KEY (id_cat) REFERENCES t_categorias(id),
    FOREIGN KEY (id_esteticista) REFERENCES t_esteticistas(id),
    FOREIGN KEY (id_usuario) REFERENCES t_usuarios(id) ON UPDATE CASCADE,
    FOREIGN KEY (id_estado) REFERENCES t_estados(id) ON UPDATE CASCADE
);