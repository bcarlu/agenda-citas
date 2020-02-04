<?php 

	include_once'conexion.php';

	$salida = "";
	$queryCitas = "SELECT * FROM t_citas";

	if (isset($_POST['consulta'])) {
		$q = mysqli_real_escape_string($conexion, $_POST['consulta']);
		$queryCitas = "SELECT * FROM t_citas WHERE id_cita LIKE '%".$q."%' OR  ";
	}