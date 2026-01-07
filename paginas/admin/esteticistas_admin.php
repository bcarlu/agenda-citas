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
<?php       
    //Fin if de control sesion
    }
    else {
        echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='/ingreso.php'>inicia sesión</a> :)</h3></div> ";
    }
?>
</body>
</html>