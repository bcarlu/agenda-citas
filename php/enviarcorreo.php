<?php

//Se inicia la sesion
session_start();
$usuario = $_SESSION['username'];

if (isset($usuario)) {

	//Datos del cliente y cita. Recibidos por metodo GET.
	$servicio = $_GET['serv'];
	$dia = $_GET['dia'];
	$mes = $_GET['mes'];
	$hora = $_GET['hora'].":00"; // Se concatena los dos ceros para que strftime lo interprete correctamente como hora.
	$horafin = $_GET['horafin'].":00"; // Se concatena los dos ceros para que strftime lo interprete correctamente como hora.
	$esteticista = $_GET['est'];
	$precio = $_GET['precio'];
	$anio = date('Y');

	//Se convierte fecha y hora en formato textual y en espanol
	setlocale(LC_TIME, 'es_CO.utf8');
	$fecha = strftime("%a %e de %b", strtotime("$dia-$mes-$anio"));
	$horai = strftime("%l%P", strtotime($hora));
	$horaf = strftime("%l%P", strtotime($horafin));


    //Se consulta t_usuarios y se define nombre cliente
    // TODO: Migrar consulta a postgresql cuando se retome envio de correo
    // TODO: Obtener nombre cliente
    //$nomCli = $nomCli['nombre'];
    

    //Se consulta t_esteticistas y se define nombre esteticista
    // TODO: Obtener nombre esteticista
    // $nomEst = $nomEst['nombre'] ." ". $nomEst['apellidos'];

    //Se habilitan mensajes de error
	ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    
    //Datos del correo
    $from = " Unas y Spa <info@yosoypc.com>";
    $to = "$usuario";
    $subject = "Confirmacion - $servicio  $fecha a las $horai";
    $message = "Hola $nomCli tu cita ha sido agendada con exito :) Recuerda, $servicio $fecha de $horai a $horaf con $nomEst Te esperamos pronto.";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    
    //Despues de enviar el correo se redirecciona a la home del cliente
    header('location: ../inicio.php?agenda=exito');
    
}else{
	echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='../'>inicia sesión</a> :)</h3></div> ";
}