<?php session_start();?>
<?php $titulo = "Inicio";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<?php
$usuario = $_SESSION['username'];
if (isset($usuario)) {
?>

<body>
<?php include_once'navbar.php';?>
<?php include_once'navsesion.php';?>
<div class="container">
    <div class="row">
        <div class="col text-center">
            <img src="img/avatar-usuario.png" alt="..." class="rounded-circle"><br>
            <small><?php echo $usuario;?></small>
        </div>
          
    </div>
    <div class="row pt-5">
        <div class="col">
            <h4>Mis citas</h4>
            <?php citasxCliente(); ?>
        <!--Fin col-->
        </div>
        
    <!--Fin row-->
    </div> 
     
    <!--Boton agendar-->
    <footer class="footer mt-auto py-2 fixed-bottom">
        <div class="container text-right">
            <a href="categorias" class=" btn btn-success rounded">
            <span class="d-block">+</span>
            <small class="d-block">Agendar</small></a>
        </div>
    </footer>
   
        
  

<!--Fin container-->
</div>

<?php 
    //if agenda
    if ($_GET['agenda'] == "exito") {
?>    
    <script> alert ("Cita registrada con Exito!"); </script>
<?php
    //Fin if agenda
    }

//Cierre del if sesion
}else {
    echo ":( no has ingresado tus datos, por favor <a href='./'>inicia sesión</a> :)";
}
?>
</body>