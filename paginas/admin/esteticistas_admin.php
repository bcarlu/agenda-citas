<?php session_start();?>
<?php $titulo = "Esteticistas";?>
<?php include_once'../../head.php';?>
<?php include_once'../../php/funciones.php';?>

<?php
//Valida si la variable global del usuario esta definida
if (isset($_SESSION['username']) && $_SESSION['id_rol'] === 1) {
    $usuario = $_SESSION['username'];
?>
<body>
    <?php include '../../navbar.php';?>
    <div class="container mt-5">
        <div class="row py-3">
            <div class="col">
                <h3>Esteticistas</h3>                
            </div>  
            <div class="col-auto">
                <a class="btn btn-outline-primary" href="/paginas/admin/nueva_esteticista.php" role="button">Nueva Esteticista</a>
            </div>                    
        </div>
        <?php
            // Alerta de exito
            if (isset($_GET['esteticista'])) { // Valida si se recibe la variable
                if ($_GET['esteticista'] == "exito") {
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Esteticista creada con exito!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
                } // Cierre if
            } // Cierre if
        ?>        
        <div class="row">
            <div class="col-3">
                <?php include 'navbar_lateral.php';?>
            </div>
            <div class="col-9">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo listaEsteticistasAdmin(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Confirmacion eliminar esteticista -->
    <div class="modal fade" id="modal-eliminar-esteticista" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            En realidad deseas eliminar el esteticista?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <form action="../../php/admin/eliminar_esteticista.php" method="post">
                <input type="hidden" class="hidden" name="id-esteticista" id="id-esteticista"> <!-- El valor se pasa con jquery-->
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>            
        </div>
        </div>
    </div>
    </div>
    <script>
        // Se utiliza jquery de bootstrap para pasar el id del esteticista que se va a eliminar al modal.
        $('.btn-eliminar-esteticista').on('click', function () {
            $('#id-esteticista').val($(this).data('idesteticista'))
        })        
    </script>
<?php       
    //Fin if de control sesion
    }
    else {
        echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
    }
?>
</body>
</html>