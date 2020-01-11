<?php
session_start();


$usuario = $_SESSION['username'];

if (isset($usuario)) {
    include_once'conexion.php';
    include_once'../head.php';
?>
<!--Nombre del usuario actual y boton para cerrar sesion-->
<div class="container">
  <a href="../inicio" class="btn btn-warning"><img class="rounded float-left" src="../img/icono-home.png" alt="" style="height:45px; width:45px;"></a>
  <div class="btn btn-primary text-wrap" style="width:150px;">
    <small><b>Bienvenido - <?php echo $_SESSION['username']; ?></b></small> 
  </div>
  <a class="btn btn-danger float-right" href="cerrarSesion"><small><b>Cerrar sesion</b></small></a>
</div>

<?php
    
    //Servicio elegido
    $servicio = $_GET['serv'];
    $anio = $_GET['anio'];
    $mes = $_GET['mes'];
    $dia = $_GET['dia'];
    $hora = $_GET['hora'];

    //Se consulta la tabla servicios 
    $consultaServicio = mysqli_query($conexion,"SELECT * FROM t_servicios WHERE nombre = '$servicio'");
    $arregloServicio = mysqli_fetch_array($consultaServicio);

    $categoria = $arregloServicio['id_cat'];
    $precio = $arregloServicio['precio'];
    $duracion = $arregloServicio['id_duracion'];

    /*$registraCita = "INSERT INTO t_citas (id_serv,id_cat,id_esteticista,email_cliente,anio,mes,dia,hora,duracion,horafin) 
    VALUES ('$servicio','$categoria','$esteticista','$celular','$clave')";
    mysqli_query($conexion,$registrarCita);*/
    
    //Mensaje de ejemplo
    echo "Felicidades!! Agenda registrada con exito :). <br>";
    echo "Servicio: " . $servicio . "<br>";
    echo "Año: " . $anio . "<br>";
    echo "Mes: " . $mes . "<br>";
    echo "Dia: " . $dia . "<br>";
    echo "Hora: " . $hora . "<br>";
    echo "Duracion: " . $duracion . "<br>";
    echo "Precio: " . $precio . "<br>";
}else {
    echo ":( no has ingresado tus datos, por favor <a href='../'>inicia sesión</a> :)";
}