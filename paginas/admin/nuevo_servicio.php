<?php session_start();?>
<?php $titulo = "Nuevo servicio";?>
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
                <h2 class="h4">Nuevo servicio</h2>
            </div>
            <div class="col-12 col-md-5">
                <?php
                // Validar si hay categorias creadas, si no informar y agregar boton para crear categoria.
                    $categoriasDatos = obtenerCategorias();
                    if($categoriasDatos) {
                ?>
                <form id="form-crear-cuenta" action="/php/admin/crear_servicio.php" method="post">
                    <div class="form-group">
                        <label for="nombre-usu-cuenta">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control campo-input" id="nombre-servicio" name="nombre-servicio" aria-describedby="nombreAyuda" placeholder="Nombre del servicio" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria-servicio">Categoria <span class="text-danger">*</span></label>
                        <select class="form-control" name="categoria-servicio" id="categoria-servicio" name="categoria-servicio">
                            <option value="0">Seleccione</option>
                            <?php foreach ($categoriasDatos as $categoria) { ?>
                                <option value="<?php echo htmlspecialchars($categoria["id"]); ?>">
                                    <?php echo "ID-" .htmlspecialchars($categoria["id"]) . ": " . htmlspecialchars($categoria["nombre"]); ?>
                                </option>
                            <?php } // Cierre foreach ?>                            
                        </select>                        
                    </div>
                    <div class="form-group">
                        <label for="precio-servicio">Precio <span class="text-danger">*</span></label>
                        <input type="number" class="form-control campo-input" id="precio-servicio" name="precio-servicio" aria-describedby="emailAyuda" placeholder="Sin puntos ej: 25000" required>
                    </div>
                    <div class="form-group">
                        <label for="duracion-servicio">Duracion (en horas) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control campo-input" id="duracion-servicio" name="duracion-servicio" aria-describedby="celularAyuda" placeholder="Ej: 1" required>
                    </div>                             
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Crear servicio</button>
                    </div>
                </form>
                <?php } else { ?>
                    <div class="alert alert-warning" role="alert">
                        <p class="text-center">Aun no tienes categorias creadas, crea una para asociarla al servicio. <a class="text-primary" href="/paginas/admin/nueva_categoria.php">Crear categoria</a></p> 
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