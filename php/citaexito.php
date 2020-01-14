<?php
session_start();
include_once'head.php';

$usuario = $_SESSION['username'];

if (isset($usuario)) {
?>
    <!--Nombre del usuario actual y boton para cerrar sesion-->
    <div class="container">
        <a href="../inicio" class="btn btn-warning"><img class="rounded float-left" src="../img/icono-home.png" alt="" style="height:45px; width:45px;"></a>
        <a class="btn btn-danger float-right" href="cerrarSesion"><small><b>Cerrar sesion</b></small></a>
    </div>
    <div class="alert alert-success" role="alert">
    Cita programada con EXITO!
    </div>
    
<?php
}else {
    echo ":( no has ingresado tus datos, por favor <a href='../'>inicia sesión</a> :)";
}