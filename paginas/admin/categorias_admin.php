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
    <?php include 'navbar.php';?>
    <div class="container mt-5">
        <div class="row py-3">
            <div class="col">
                <h3>Categorias</h3>                
            </div>  
            <div class="col-auto">
                <a class="btn btn-outline-primary" href="/paginas/admin/nueva_categoria.php" role="button">Nueva Categoria</a>
            </div>                    
        </div>
        <?php
            // Alerta de exito
            if (isset($_GET['categoria'])) { // Valida si se recibe la variable
                if ($_GET['categoria'] == "exito") {
        ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Categoria creada con exito!</strong>
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
                        <th scope="col">Categoria</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo listaCategoriasAdmin(); ?>
                </tbody>
            </table>
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