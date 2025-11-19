<?php $titulo = "Ingreso";?>
<?php include_once'head.php';?>

<body>

    <?php include_once'navloginreg.php';?>
    <div class="container">        
        <div class="row justify-content-md-center" style="padding:50px 0px;">            
            <div class="col-12 col-md-7 text-center mb-4">
                <h2>Bienvenido!</h2>
            </div>
            <div class="col-12 col-md-5">
                <?php
                // Alerta de registro exitoso
                if (isset($_GET['registro'])) { // Valida si se recibe la variable
                    if ($_GET['registro'] == "exitoso") { // Valida si es exitoso
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Registro exitoso!</strong> Ahora puedes iniciar sesion.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                <?php
                    //Cierre if modal
                    }                
                //Cierre if de control
                }
                // Alerta error ingreso
                if (isset($_GET['error'])) { // Valida si se recibe la error
                    if ($_GET['error'] == "clave_incorrecta" || $_GET['error'] == "usuario_no_registrado") {
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Clave o usuario incorrecto!</strong> Verifica los datos e intentalo nuevamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                <?php                    
                    } //Cierre if error                
                } //Cierre if de control
                ?>
                <!--Formulario de Login-->                
                <form class="login-form" action="php/validalogin_pg.php" method="post">
                    <div class="form-group">
                        Email
                        <input type="email" class="form-control campo-input" id="email" aria-describedby="emailHelp" name="email" required>
                    </div>
                    <div class="form-group">
                        Clave
                        <input type="password" class="form-control campo-input" id="clave" name="clave" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn bt-ingresar btn-block">Ingresar</button>
                    </div>
                </form>
            </div>          
        </div>
    </div>
</body>
</html>