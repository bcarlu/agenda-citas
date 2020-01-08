
<!--Funcion en Javascript para el boton volver a la pagina anterior y hacerlo automaticamente.-->
<script>
function goBack() {
  window.history.back()
}
</script>

<!--Nombre del usuario actual y boton para cerrar sesion-->

  <button class="btn btn-warning" onclick="goBack()"><img class="rounded float-left" src="img/volver-flecha.png" alt="" style="height:45px; width:45px;"></button>
  <!--
  <div class="btn btn-primary text-wrap" style="width:150px;">
    <small><b>Bienvenido - <?php echo $_SESSION['username']; ?></b></small> 
  </div>
  -->
  <a class="btn btn-danger float-right" href="php/cerrarSesion.php"><small><b>Cerrar sesion</b></small></a>

