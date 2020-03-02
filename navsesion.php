
<!--Funcion en Javascript para el boton volver a la pagina anterior y hacerlo automaticamente.-->
<script>
function goBack() {
  window.history.back();
}
</script>


<!-- Image and text -->
<nav class="navbar navbar-light bg-light navsesion">
  <a class="navbar-brand" href="#" onclick="goBack()">
    <i class="fas fa-angle-left fa-lg align-middle"></i>
    <small> Volver</small>
  </a>
</nav>