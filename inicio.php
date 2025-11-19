<?php session_start();?>
<?php $titulo = "Inicio";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<?php
//Valida si la variable global del usuario esta definida
if (isset($_SESSION['username'])) {
    $usuario = $_SESSION['username'];
?>

    <body class="bodyinicio">
    <?php include 'navbar.php';?>
    <div class="container">
        <div class="row pt-5 mt-5">
            <div class="col">
                <h5>Mis citas</h5>
                <?php
                // Alerta cita registrada con exito
                if (isset($_GET['agenda'])) {        
                    //if agenda        
                    if ($_GET['agenda'] == "exito") {
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Cita registrada con exito!</strong> Te esperamos pronto.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                <?php                    
                    } //Cierre if error                
                } //Cierre if de control
                ?>
                <!--Se llama funcion para mostrar citas-->
                <?php citasxClientePG($usuario); ?>
            <!--Fin col-->
            </div>        
        <!--Fin row-->
        </div> 
        <!--Boton agendar-->
        <footer class="footer mt-auto py-2 fixed-bottom">
            <div class="container text-right">            
                <a href="categorias.php" class="btn rounded botonplus">
                <i class="fas fa-plus d-block fa-2x"></i>
                <small class="d-block font-weight-bold text-muted">Agendar</small></a>
            </div>
        </footer>

    <!--Fin container-->
    </div>

    <?php       
    //Fin if de control sesion
    }
    else {
        echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='./'>inicia sesión</a> :)</h3></div> ";
    }
    ?>
</body>
