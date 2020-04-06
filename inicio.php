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
                <!--Se llama funcion para mostrar citas-->
                <?php citasxCliente(); ?>
            <!--Fin col-->
            </div>        
        <!--Fin row-->
        </div> 
        
        <!--Boton agendar-->
        <footer class="footer mt-auto py-2 fixed-bottom">
            <div class="container text-right">            
                <a href="categorias" class="btn rounded botonplus">
                <i class="fas fa-plus d-block fa-2x"></i>
                <small class="d-block font-weight-bold text-muted">Agendar</small></a>
            </div>
        </footer>

    <!--Fin container-->
    </div>

    <?php
        //if de control var agenda
        if (isset($_GET['agenda'])) {        
            //if agenda        
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
            //Fin if de agenda
            }
        //Fin if de control var agenda
        }        
    //Fin if de control sesion
    }
    else {
        echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='./'>inicia sesión</a> :)</h3></div> ";
    }
    ?>
</body>