<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
 
$usuario = $_SESSION['username'];

if (isset($usuario)) {

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	//Datos de conexion:
	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = 'mail.yosoypc.com';
	$mail->Port = '465';
	$mail->Username = 'info@yosoypc.com';
	$mail->Password = '1Nf0-ypc';



	//Direccion origen:
	$mail->setFrom('info@yosoypc.com', 'AgendaT');

	//Direccion de destino:
	$mail->addAddress($usuario,'Cliente');

	//Asunto:
	$mail->Subject = 'Confirmacion cita';

	//Mensaje:
	$mail->Body = 'Cita registrada con exito';

	if ($mail->send()) {
		echo 'enviado';
		header('location: ../inicio.php?agenda=exito');
	} else{
		echo 'Error';
	}
}else{
	echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='../'>inicia sesión</a> :)</h3></div> ";
}