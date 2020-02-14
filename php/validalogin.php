<?php
include_once'conexion.php';
session_start();

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
    		echo "la contraseña es incorrecta";
    	}
        
    }else {
        echo "No estas registrado, <a href='../registro'>puedes hacerlo aqui, es gratis</a>";
    }
}