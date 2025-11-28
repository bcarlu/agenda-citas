<?php session_start();?>
<?php $titulo = "Nueva esteticista";?>
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
        <div class="row justify-content-md-center" style="padding:50px 0px;">
            <div class="col-12 text-center mb-4">
                <h2 class="h4">Nueva esteticista</h2>
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
                    if ($_GET['error'] == "error_al_crear_esteticista" || $_GET['error'] == "error_interno") { // Error 2
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error al crear esteticista!</strong> Por favor intentalo de nuevo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    } // Cierre if error 2              
                } //Cierre if de control isset
                ?>
                <?php
                // Validar si hay categorias creadas, si no informar y agregar boton para crear categoria.
                    $categoriasDatos = obtenerCategorias();
                    if($categoriasDatos) {
                ?>
                <form id="form-crear-esteticista" action="/php/admin/crear_esteticista.php" method="post">
                    <div class="form-group">
                        <label for="nombre-esteticista">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control campo-input" id="nombre-esteticista" name="nombre-esteticista" aria-describedby="nombreAyuda" placeholder="Nombre completo esteticista" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria-esteticista">Categoria <span class="text-danger">*</span></label>
                        <select class="form-control" name="categoria-esteticista" id="categoria-esteticista" required>
                            <option value="0">Seleccione</option>
                            <?php foreach ($categoriasDatos as $categoria) { ?>
                                <option value="<?php echo htmlspecialchars($categoria["id"]); ?>">
                                    <?php echo "ID-" .htmlspecialchars($categoria["id"]) . ": " . htmlspecialchars($categoria["nombre"]); ?>
                                </option>
                            <?php } // Cierre foreach ?>                            
                        </select>                        
                    </div>                            
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Crear esteticista</button>
                    </div>
                </form>
                <?php } else { ?>
                    <div class="alert alert-warning" role="alert">
                        <p class="text-center">Aun no tienes categorias creadas, crea una para asociarla a la esteticista. <a class="text-primary" href="/paginas/admin/nueva_categoria.php">Crear categoria</a></p> 
                    </div>                                     
                <?php } // Fin if validacion categorias ?>
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