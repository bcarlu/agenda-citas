<?php
session_start();


$usuario = $_SESSION['username'];

if (isset($usuario)) {    

    //Se incluye conexion a mysql
    include_once'conexion.php';
        
    //Servicio escogido
    $servicioEscogido = $_GET['serv'];
    $anio = $_GET['anio'];
    $mes = $_GET['mes'];
    $dia = $_GET['dia'];
    $hora = $_GET['hora'];    
    $esteticista = $_GET['est'];

    //Se define el id, categoria, precio y duracion del servicio escogido 
    $consultaServicio = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$servicioEscogido'");
    $arregloServicio = mysqli_fetch_array($consultaServicio);
    $idServicio = $arregloServicio['id_serv'];
    $categoria = $arregloServicio['id_cat'];
    $precio = $arregloServicio['precio'];
    $duracion = $arregloServicio['id_duracion'];
    $horafin = $hora + $duracion;

    //Antes de registrar la cita se busca que no la hallan reservado ya y asi evitar agendas duplicadas.
    $sqlRegistroCita = "SELECT id_cita FROM t_citas WHERE id_esteticista='$esteticista' AND anio='$anio' AND mes='$mes' AND dia='$dia' AND hora='$hora' AND horafin='$horafin'";
    $resultRegistroCita = $conn->query($sqlRegistroCita);
    $estadoRegCita = $resultRegistroCita->fetch_assoc();

    //Si ya se agendo
    if ($resultRegistroCita->num_rows > 0) {
        header("location: ../agenda.php?serv=$servicioEscogido&agendado=si");
    }
    //Si no se ha agendado se registra normalmente
    else {

    //Registra cita
    mysqli_query($conexion,"INSERT INTO t_citas (id_serv,id_cat,id_esteticista,email_cliente,anio,mes,dia,hora,duracion,horafin) 
    VALUES ('$idServicio','$categoria','$esteticista','$usuario','$anio','$mes','$dia','$hora','$duracion','$horafin')");
    
    /*Se redirecciona a la pagina de enviar correo y debido a que se envian datos por GET con variables se utilizan comillas dobles*/
    header("location: enviarcorreo.php?serv=$servicioEscogido&est=$esteticista&dia=$dia&mes=$mes&hora=$hora&horafin=$horafin&precio=$precio");
    
    }

}
//Si no ha iniciado sesion
else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='../'>inicia sesión</a> :)</h3></div> ";
}