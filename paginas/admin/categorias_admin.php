<?php session_start();?>
<?php $titulo = "Categorias";?>
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
                <h3>Categorias</h3>                
            </div>  
            <div class="col-auto">
                <a class="btn btn-outline-primary" href="/paginas/admin/nueva_categoria.php" role="button">Nueva Categoria</a>
            </div>                    
        </div>       
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
                                <th scope="col">Categoria</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo listaCategoriasAdmin(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmacion eliminar categoria -->
    <div class="modal fade" id="modal-eliminar-categoria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            En realidad deseas eliminar la categoria?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <form action="../../php/admin/eliminar_categoria.php" method="post">
                <input type="hidden" class="hidden" name="id-categoria" id="id-categoria"> <!-- El valor se pasa con jquery-->
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>            
        </div>
        </div>
    </div>
    </div>
    <script>
        // Se utiliza jquery de bootstrap para pasar el id de la categoria que se va a eliminar al modal.
        $('.btn-eliminar-categoria').on('click', function () {
            $('#id-categoria').val($(this).data('idcategoria'))
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