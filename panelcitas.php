<?php session_start();?>
<?php $titulo = "Panel citas";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h3 class="py-3">Panel de citas</h3>
            </div>            
        </div>
        <form>
            <div class="form-group">
                <label>Buscar</label>
                <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Escribe lo que buscas">
            </div>
            
        </form>
        <div id="datos">
                
        </div>
        <div>
            <?php panelCitas(); ?>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>