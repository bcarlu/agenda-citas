
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
    		echo "<div class='container'><h3 class='alert alert-success text-center'>:( La contraseña es incorrecta. <a href='../'>Volver a intentarlo.</a></h3></div>";
    	}
        
    }else {
        echo "<div class='container'><h3 class='alert alert-success text-center'>No estas registrado, <a href='../registro'>puedes hacerlo aqui, es gratis</a></h3></div>";
    }
    
    //Cierra conexion a mysql
    mysqli_close($conexion);
}