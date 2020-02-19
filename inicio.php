<?php session_start();?>
<?php $titulo = "Inicio";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<?php
$usuario = $_SESSION['username'];
if (isset($usuario)) {
?>

<body class="bodyinicio">
<?php include_once'navbar.php';?>
<?php include_once'navsesion.php';?>
<div class="container">
    <div class="row">
        <div class="col text-center">
            <img src="img/avatar-usuario.png" alt="..." class="rounded-circle"><br>
            <small><?php //nombreCliente($usuario); ?></small>
        </div>
          
    </div>
    <div class="row pt-5">
        <div class="col">
            <h5>Mis citas</h5>
            <?php citasxCliente(); ?>
        <!--Fin col-->
        </div>
        
    <!--Fin row-->
    </div> 
     
    <!--Boton agendar-->
    <footer class="footer mt-auto py-2 fixed-bottom">
        <div class="container text-right">            
            <a href="categorias" class="btn rounded linkbtnplus">
            <i class="fas fa-plus d-block botonplus"></i>
            <small class="d-block font-weight-bold">Agendar</small></a>
        </div>
    </footer>

<!--Fin container-->
</div>

<?php 
    //if agenda
    $agenda = "";
    if ($_GET['agenda'] == "exito") {
?>  
    <div class="modal" tabindex="-1" role="dialog" id="aviso">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Cita registrada con exito!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
            </div>
        </div>
    </div>
    <script> 
        $('#aviso').modal('show'); 
    </script>
    
<?php
    //Fin if agenda
    }

//Cierre del if sesion
}else {
    echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='./'>inicia sesión</a> :)</h3></div> ";
}
?>
</body>