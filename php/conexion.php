<?php 

$servidor = "localhost";
$user = "root";
$passwd = "";
$datab = "agenda_citas";

$conexion = mysqli_connect($servidor,$user,$passwd,$datab) or die ("Ups falló la conexión a la base de datos");

$conn = new mysqli($servidor, $user, $passwd, $datab);