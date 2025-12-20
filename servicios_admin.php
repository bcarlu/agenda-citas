<?php session_start();?>
<?php $titulo = "Panel citas";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<?php
//Valida si la variable global del usuario esta definida
if (isset($_SESSION['username']) && $_SESSION['id_rol'] === 1) {
    $usuario = $_SESSION['username'];
?>
<body>
    <?php include 'navbar.php';?>
    <div class="container mt-5">
        <div class="row py-3">
            <div class="col">
                <h3>Servicios</h3>                
            </div>  
            <div class="col-auto">
                <a class="btn btn-outline-primary" href="/paginas/admin/nuevo_servicio.php" role="button">Nuevo Servicio</a>
            </div>                    
        </div>
        <?php
            // Alertas
            if (isset($_GET['servicio']) || isset($_GET['error'])) { // Valida si se recibe la variable
                if ($_GET['servicio'] == "exito") {
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Servicio creado con exito!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
                } // Cierre if exito
                if ($_GET['servicio'] == "sin_cambios" || $_GET['error'] == "servicio_no_existe") {
        ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>No se hicieron cambios!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
                } // Cierre if sin_cambios
                if ($_GET['servicio'] == "actualizado") {
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Servicio actualizado!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
                } // Cierre if actualizado            
            } // Cierre if
        ?>
        <div class="row">
            <div class="col-3">
                <?php include 'paginas/admin/navbar_lateral.php';?>
            </div>
            <div class="col-9">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Servicio</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Duracion (horas)</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo listaServiciosAdmin(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    

    <!-- Modal Confirmacion eliminar servicio -->
    <div class="modal fade" id="modal-eliminar-servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            En realidad deseas eliminar el servicio?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <form action="php/admin/eliminar_servicio.php" method="post">
                <input type="hidden" class="hidden" name="id-servicio" id="id-servicio"> <!-- El valor se pasa con jquery-->
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>            
        </div>
        </div>
    </div>
    </div>
    <script>
        // Se utiliza jquery de bootstrap para pasar el id del servicio que se va a eliminar al modal.
        $('.btn-eliminar-servicio').on('click', function () {
            $('#id-servicio').val($(this).data('idservicio'))
            console.log("Id servicio: ",$(this).data('idservicio'))
        })        
    </script>
<?php       
    //Fin if de control sesion
    }
    else {
        echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='./'>inicia sesión</a> :)</h3></div> ";
    }
?>
</body>
</html>