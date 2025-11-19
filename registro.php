<?php $titulo = "Crear cuenta";?>
<?php include_once'head.php';?>
<body>
    
    <?php include_once'navloginreg.php';?>

    <div class="container">        
        <div class="row justify-content-md-center" style="padding:50px 0px;">
            <div class="col-12 col-md-7 text-center mb-4">
                <h2 class="h4">Crea una cuenta gratis y agenda tus citas rapida y facilmente!</h2>
            </div>
            <div class="col-12 col-md-5">
                <?php
                // Alerta de error
                if (isset($_GET['error'])) { // Valida si se recibe la variable
                    if ($_GET['error'] == "email_ya_registrado") { // Error 1
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Email ya registrado!</strong> Inicia sesion o intenta con otro correo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    } // Cierre if error 1
                    if ($_GET['error'] == "error_al_crear_usuario" || $_GET['error'] == "error_interno") { // Error 2
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error al registrar usuario!</strong> Por favor intentalo de nuevo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    } // Cierre if error 2                
                } //Cierre if de control
                ?>
                <form action="php/validaregistro_pg.php" method="post">
                    <div class="form-group">
                        Nombre
                        <input type="text" class="form-control campo-input" id="nombre-reg" name="nombre-reg" aria-describedby="nombreAyuda" placeholder="Escriba su nombre" required>
                    </div>
                    <div class="form-group">
                        Apellidos
                        <input type="text" class="form-control campo-input" id="apellidos-reg" name="apellidos-reg" aria-describedby="apellidosAyuda" placeholder="Escriba sus apellidos">
                    </div>
                    <div class="form-group">
                        Email
                        <input type="email" class="form-control campo-input" id="email-reg" name="email-reg" aria-describedby="emailAyuda" placeholder="Escriba su email" required>
                    </div>
                    <div class="form-group">
                        Celular
                        <input type="tel" class="form-control campo-input" id="celular-reg" name="celular-reg" aria-describedby="celularAyuda" placeholder="Escriba su numero celular" pattern="[0-9]{10}">
                    </div>
                    <div class="form-group">
                        Contraseña
                        <input type="password" class="form-control campo-input" id="clave-reg" name="clave-reg" placeholder="Escriba una contraseña para su cuenta" required>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="mostrarContrasena()">
                        <label class="custom-control-label" for="customCheck1">Ver contraseña</label>
                    </div>           
                    <div class="form-group">
                        <button type="submit" class="btn btn-block bt-crear-cuenta">Crear cuenta</button>
                    </div>
                </form>
            </div>

        </div>        
    </div>
</body>
</html>
