<?php session_start();?>
<?php $titulo = "Editar servicio";?>
<?php include_once'../../head.php';?>
<?php include_once'../../php/funciones.php';?>

<?php
//Valida si la variable global del usuario esta definida
if (isset($_SESSION['username']) && $_SESSION['id_rol'] === 1) {
    $usuario = $_SESSION['username'];
    // Se procesan las variables con los datos del servicio
    $idServicio = $_GET["id_serv"];
    $nombreServicio = $_GET["nom_serv"];
    $idCategoria = $_GET["id_cat"];
    $nombreCategoria = $_GET["nom_cat"];
    $precio = $_GET["precio"];
    $duracion = $_GET["duracion"];
?>
<body>
    <?php include '../../navbar.php';?>
    <div class="container mt-5">        
        <div class="row justify-content-md-center" style="padding:50px 0px;">
            <div class="col-12 text-center mb-4">
                <h2 class="h4">Editar servicio</h2>
            </div>
            <div class="col-12 col-md-5">
                <form id="form-crear-cuenta" action="/php/admin/actualizar_servicio.php" method="post">
                    <input type="hidden" class="hidden" name="id-servicio" id="id-servicio" value="<?php echo htmlspecialchars($idServicio)?>">
                    <div class="form-group">
                        <label for="nombre-servicio">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control campo-input" id="nombre-servicio" name="nombre-servicio" aria-describedby="nombreAyuda" placeholder="Nombre del servicio" required value="<?php echo htmlspecialchars($nombreServicio) ;?>">
                    </div>
                    <div class="form-group">
                        <label for="categoria-servicio">Categoria <span class="text-danger">*</span></label>
                        <select class="form-control" name="categoria-servicio" id="categoria-servicio" name="categoria-servicio" required>
                            <option value="">Seleccione una categoria</option>
                            <?php $categoriasDatos = obtenerCategorias(); // Se obtienen categorias de la cuenta
                                foreach ($categoriasDatos as $categoria) { ?>
                                <option value="<?php echo htmlspecialchars($categoria["id"]); ?>" <?php if ($categoria["id"] == $idCategoria) {echo "selected";} ?>>
                                    <?php echo "ID-" .htmlspecialchars($categoria["id"]) . ": " . htmlspecialchars($categoria["nombre"]); ?>
                                </option>
                            <?php } // Cierre foreach ?>                            
                        </select>                        
                    </div>
                    <div class="form-group">
                        <label for="precio-servicio">Precio <span class="text-danger">*</span></label>
                        <input type="number" class="form-control campo-input" id="precio-servicio" name="precio-servicio" aria-describedby="emailAyuda" placeholder="Sin puntos ej: 25000" required value="<?php echo htmlspecialchars($precio) ;?>">
                    </div>
                    <div class="form-group">
                        <label for="duracion-servicio">Duracion (en horas) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control campo-input" id="duracion-servicio" name="duracion-servicio" aria-describedby="celularAyuda" placeholder="Ej: 1" required value="<?php echo htmlspecialchars($duracion) ;?>">
                    </div>                             
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Actualizar</button>
                        <a type="button" class="btn btn-block btn-danger" href="/servicios_admin.php">Cancelar</a>
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