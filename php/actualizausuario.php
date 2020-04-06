<?php 
include_once'conexion.php';

//Variable para encriptar la clave que el usuario ingresa.
$clavenc = password_hash("123", PASSWORD_BCRYPT);

$sql = "UPDATE t_clientes SET clave='$clavenc' WHERE email='dicabo65@hotmail.com'";


if ($conn->query($sql) === TRUE) {
    echo "Clave actualizada con exito";
} else {
    echo "Error actualizando" . $conn->error;
}

$conn->close();	