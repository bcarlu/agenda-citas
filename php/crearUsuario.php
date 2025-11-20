<?php
declare(strict_types=1);

function crearUsuario(string $nombre, ?string $apellidos, string $email, ?string $celular, string $clavenc): int|false {
    try {
        // Importar conexion a la db
        include_once'conexionpg.php';
        $db = ConectorPG::obtenerInstancia();
        $pdo = $db->conectar();

        // Registrar nuevo usuario
        $stmt = $pdo->prepare('INSERT INTO t_usuarios (nombre,apellidos,email,celular,clave) VALUES (:nombre,:apellidos,:email,:celular,:clavenc)');
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':celular', $celular, PDO::PARAM_STR);
        $stmt->bindValue(':clavenc', $clavenc, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return (int)$pdo->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        error_log("Error al crear el usuario: " . $e->getMessage(), (int)$e->getCode());
        return false;
    }
}