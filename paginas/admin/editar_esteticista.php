<?php session_start();?>
<?php $titulo = "Editar esteticista";?>
<?php include_once'../../head.php';?>
<?php include_once'../../php/funciones.php';?>

<?php
//Valida si la variable global del usuario esta definida
if (isset($_SESSION['username']) && $_SESSION['id_rol'] === 1) {
    $usuario = $_SESSION['username'];
    // Se procesan las variables con los datos de la esteticista
    $idEsteticista = $_GET["id_estet"];
    $nombreEsteticista = $_GET["nom_estet"];
    $idCategoria = $_GET["id_cat"];
?>
<body>
    <?php include '../../navbar.php';?>
    <div class="container mt-5">        
        <div class="row justify-content-md-center" style="padding:50px 0px;">
            <div class="col-12 text-center mb-4">
                <h2 class="h4">Editar esteticista</h2>
            </div>
            <div class="col-12 col-md-5">
                <form id="form-editar-esteticista" action="/php/admin/actualizar_esteticista.php" method="post">
                    <input type="hidden" class="hidden" name="id-esteticista" id="id-esteticista" value="<?php echo htmlspecialchars($idEsteticista)?>">
                    <div class="form-group">
                        <label for="nombre-esteticista">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control campo-input" id="nombre-esteticista" name="nombre-esteticista" aria-describedby="nombreAyuda" placeholder="Nombre" required value="<?php echo htmlspecialchars($nombreEsteticista) ;?>">
                    </div>
                    <div class="form-group">
                        <label for="categoria-esteticista">Categoria <span class="text-danger">*</span></label>
                        <select class="form-control" name="categoria-esteticista" id="categoria-esteticista" required>
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
                        <button type="submit" class="btn btn-block btn-primary">Actualizar</button>
                        <a type="button" class="btn btn-block btn-danger" href="/paginas/admin/esteticistas_admin.php">Cancelar</a>
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