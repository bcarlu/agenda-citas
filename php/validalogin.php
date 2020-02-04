<?php
include_once'conexion.php';
session_start();

$email = $_POST['email'];
$clave = $_POST['clave'];

if (isset($_POST)) {
    //Valida si el usuario esta registrado
    $consultaLogin = mysqli_query($conexion,"SELECT COUNT(*) AS usuario FROM t_clientes WHERE email='$email' and clave='$clave'");
    $resultadoLogin = mysqli_fetch_assoc($consultaLogin);

    if ($resultadoLogin['usuario'] > 0) {
        $_SESSION['username'] = $email;
        header("location:../inicio");
    }else {
        echo "No estas registrado, <a href='../registro'>puedes hacerlo aqui, es gratis</a>";
    }
}