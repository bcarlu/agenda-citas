<?php session_start();?>
<?php $titulo = "Panel citas";?>
<?php include_once'head.php';?>
<?php include_once'php/funciones.php';?>

<?php
//Valida si la variable global del usuario esta definida
if (isset($_SESSION['username'])) {
    $usuario = $_SESSION['username'];
?>
<body>
    <?php include 'navbar.php';?>
    <div class="container mt-5">        
        <div class="row">
            <div class="col">
                <h3 class="py-3">Panel de citas</h3>
            </div>            
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Esteticista</th>
                        <th scope="col">Servicio</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Celular</th>                    
                    </tr>
                </thead>
                <tbody>
                    <?php echo listaCitas(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/main.js"></script>

<?php       
    //Fin if de control sesion
    }
    else {
        echo "<div class='container'><h3 class='alert alert-danger text-center mt-3'>:( no has ingresado, por favor <a href='./'>inicia sesión</a> :)</h3></div> ";
    }
?>
</body>
</html>