
<!--Funcion en Javascript para el boton volver a la pagina anterior y hacerlo automaticamente.-->
<script>
function goBack() {
  window.history.back();
}
</script>

<div class="container pb-2 navsesion">
<!--Nombre del usuario actual y boton para cerrar sesion-->
  <button class="btn btn-warning" onclick="goBack()"><img class="rounded float-left" src="img/volver-flecha.png" alt="" style="height:35px; width:35px;"></button>
  <a class="btn btn-danger float-right" href="php/cerrarSesion.php"><small><b>Cerrar sesion</b></small></a>
</div>