<?php session_start();?>
<?php $titulo = "Configuracion";?>
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
                <h3>Configuracion</h3>                
            </div>          
        </div>       
        <div class="row">
            <div class="col-3">
                <?php include 'navbar_lateral.php';?>
            </div>
            <!-- Listado de configuraciones-->
            <div class="col-9">            
                <!-- URL registro clientes -->
                <h5 class="h5">URL para el registro de clientes</h5>
                <p>Comparte esta URL con tus clientes para que se registren y puedan reservar citas.</p>
                <div class="card">                    
                    <div class="card-body font-italic">                        
                        <?php echo $_SERVER["SERVER_NAME"] . "/registro.php?id_cuenta=" . $_SESSION['uuid_cuenta'];?>
                    </div>
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