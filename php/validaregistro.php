<?php


if (isset($_POST['email-reg'])) {
    $titulo = "Confirmacion registro";
    include_once'../head.php';
    include_once'conexion.php';
    $nombre = $_POST['nombre-reg'];
    $apellidos = $_POST['apellidos-reg'];
    $email = $_POST['email-reg'];
    $celular = $_POST['celular-reg'];
    $clave = $_POST['clave-reg'];

    //Variable para encriptar la clave que el usuario ingresa.
    $clavenc = password_hash($clave, PASSWORD_BCRYPT);
    

    //Valida si el usuario esta registrado
    $consultaReg = mysqli_query($conexion,"SELECT COUNT(*) AS correo FROM t_clientes WHERE email='$email'");
    $resultadoReg = mysqli_fetch_assoc($consultaReg);

    if ($resultadoReg['correo'] > 0) {
        echo "El email ya está registrado, puede <a href='../'>iniciar sesion</a> o <a href='../registro'>ingresar un nuevo email.</a>";
    }else {
        $registrar = "INSERT INTO t_clientes (nombre,apellidos,email,celular,clave) VALUES ('$nombre','$apellidos','$email','$celular','$clavenc')";
        mysqli_query($conexion,$registrar);
        echo "<div class='container'><h3 class='alert alert-success text-center'>Felicidades $nombre!! te haz registrado con exito. Ahora puedes <a href='../'>ingresar</a></h3></div>";
    }

}
else {
    $titulo = "Sin datos";
    include_once'../head.php';
    echo "<div class='container'><h3 class='alert alert-success text-center'>:( No haz ingresado, por favor <a href='../'>inicia sesion</a> o <a href='../registro'>registrate ;)</a></h3></div>";
}
