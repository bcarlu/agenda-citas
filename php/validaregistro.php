<?php
include_once'conexion.php';

$nombre = $_POST['nombre-reg'];
$apellidos = $_POST['apellidos-reg'];
$email = $_POST['email-reg'];
$celular = $_POST['celular-reg'];
$clave = $_POST['clave-reg'];

if (isset($_POST)) {
    //Valida si el usuario esta registrado
    $consultaReg = mysqli_query($conexion,"SELECT COUNT(*) AS correo FROM t_clientes WHERE email='$email'");
    $resultadoReg = mysqli_fetch_assoc($consultaReg);

    if ($resultadoReg['correo'] > 0) {
        echo "El email ya está registrado, puede <a href='../'>iniciar sesion</a> o <a href='../registro'>ingresar un nuevo email.</a>";
    }else {
        $registrar = "INSERT INTO t_clientes (nombre,apellidos,email,celular,clave) VALUES ('$nombre','$apellidos','$email','$celular','$clave')";
        mysqli_query($conexion,$registrar);
        echo "Felicidades $nombre!! te haz registrado con exito. Ahora puedes <a href='../'>ingresar</a>";
    }

}else {
    echo "Sin datos, puede <a href='../'>iniciar sesion</a> o <a href='../registro'>registrarse.</a>";
}
