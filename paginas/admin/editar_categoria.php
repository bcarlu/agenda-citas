<?php session_start();?>
<?php $titulo = "Editar categoria";?>
<?php include_once'../../head.php';?>
<?php include_once'../../php/funciones.php';?>

<?php
//Valida si la variable global del usuario esta definida
if (isset($_SESSION['username']) && $_SESSION['id_rol'] === 1) {
    $usuario = $_SESSION['username'];
    // Se procesan las variables con los datos de la categoria
    $idCategoria = $_GET["id_cat"];
    $nombreCategoria = $_GET["nom_cat"];
?>
<body>
    <?php include '../../navbar.php';?>
    <div class="container mt-5">        
        <div class="row justify-content-md-center" style="padding:50px 0px;">
            <div class="col-12 text-center mb-4">
                <h2 class="h4">Editar categoria</h2>
            </div>
            <div class="col-12 col-md-5">
                <?php
                // Alerta de error
                if (isset($_GET['error'])) { // Valida si se recibe la variable
                    if ($_GET['error'] == "faltan_campos_obligatorios") { // Error 1
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Faltan campos obligatorios!</strong> Por favor llena todos los campos.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    } // Cierre if error 1
                    if ($_GET['error'] == "error_al_actualizar_categoria" || $_GET['error'] == "error_interno" || $_GET['error'] == "categoria_no_existe") { // Error 2
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error al actualizar categoria!</strong> Por favor intentalo de nuevo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    } // Cierre if error 2              
                } //Cierre if de control isset
                ?>
                <form id="form-editar-categoria" action="/php/admin/actualizar_categoria.php" method="post">
                    <input type="hidden" class="hidden" name="id-categoria" id="id-categoria" value="<?php echo htmlspecialchars($idCategoria)?>">
                    <div class="form-group">
                        <label for="nombre-categoria">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control campo-input" id="nombre-categoria" name="nombre-categoria" aria-describedby="nombreAyuda" placeholder="Nombre categoria" required value="<?php echo htmlspecialchars($nombreCategoria) ;?>">
                    </div>                           
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Actualizar</button>
                        <a type="button" class="btn btn-block btn-danger" href="/paginas/admin/categorias_admin.php">Cancelar</a>
                    </div>
                </form>                
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