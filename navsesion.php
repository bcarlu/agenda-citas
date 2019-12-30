<!--Nombre del usuario actual y boton para cerrar sesion-->
<div class="btn btn-primary text-wrap" style="width:150px;">
   <small><b>Bienvenido - <?php echo $_SESSION['username']; ?></b></small> 
</div>
<a class="btn btn-danger float-right" href="php/cerrarSesion.php"><small><b>Cerrar sesion</b></small></a>
