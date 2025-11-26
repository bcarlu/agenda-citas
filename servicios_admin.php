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
            // Alerta de error
            if (isset($_GET['servicio'])) { // Valida si se recibe la variable
                if ($_GET['servicio'] == "exito") {
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Servicio creado con exito!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
                } // Cierre if
            } // Cierre if
        ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Servicio</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Duracion (horas)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo listaServiciosAdmin(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php       
    //Fin if de control sesion
    }
    else {
        echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='./'>inicia sesión</a> :)</h3></div> ";
    }
?>
</body>
</html>