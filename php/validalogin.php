<?php
session_start();
require_once'conexion.php';

$email = $_POST['email'];
$clave = $_POST['clave'];

if (isset($_POST)) {
    //Valida si el usuario esta registrado
    $consultaLogin = mysqli_query($conexion,"SELECT * FROM t_clientes WHERE email='$email'");
    $resultadoLogin = mysqli_fetch_assoc($consultaLogin);
    $passwCliente = $resultadoLogin['clave'];

    if (mysqli_num_rows($consultaLogin) > 0) {
    	
    	if (password_verify($clave,$passwCliente)) {
    		$_SESSION['username'] = $email;
        	header("location:../inicio");
    	}else{
    		$titulo = "Datos incorrectos";
    		include_once'../head.php';
    		echo "<div class='container'><h3 class='alert alert-danger text-center'>:( La contraseña es incorrecta. <a href='../ingreso.php'>Volver a intentarlo.</a></h3></div>";
    	}
        
    }else {
    	$titulo = "Usuario nuevo";
    	include_once'../head.php';
        echo "<div class='container'><h3 class='alert alert-danger text-center'>No estas registrado, <a href='../registro'>puedes hacerlo aqui, es gratis</a></h3></div>";
    }
    
    //Cierra conexion a mysql
    mysqli_close($conexion);
}