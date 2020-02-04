<?php
session_start();


$usuario = $_SESSION['username'];

if (isset($usuario)) {
    
    //Se condiciona GET para poder destruir la variable y evitar reenvios de informacion al recargar la pagina.
    if (isset($_GET['serv'])) {
        include_once'conexion.php';
            
        //Servicio elegido
        $servicioEscogido = $_GET['serv'];
        $anio = $_GET['anio'];
        $mes = $_GET['mes'];
        $dia = $_GET['dia'];
        $hora = $_GET['hora'];    
        $esteticista = $_GET['est'];
    
        //Selecciona servicio elegido 
        $consultaServicio = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$servicioEscogido'");
        $arregloServicio = mysqli_fetch_array($consultaServicio);
    
        $idServicio = $arregloServicio['id_serv'];
        $categoria = $arregloServicio['id_cat'];
        $precio = $arregloServicio['precio'];
        $duracion = $arregloServicio['id_duracion'];
        $horafin = $hora + $duracion;
    
        //Registra cita
        mysqli_query($conexion,"INSERT INTO t_citas (id_serv,id_cat,id_esteticista,email_cliente,anio,mes,dia,hora,duracion,horafin) 
        VALUES ('$idServicio','$categoria','$esteticista','$usuario','$anio','$mes','$dia','$hora','$duracion','$horafin')");
        
        //Se destruye variable GET y se redirecciona.
        unset($_GET['serv']);
        header('location: enviarcorreo.php');
    }
    

}else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='../'>inicia sesión</a> :)</h3></div> ";
}