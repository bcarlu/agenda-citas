<?php $titulo = "Crear cuenta";?>
<?php include_once'head.php';?>
<body>
    
    <?php include_once'navloginreg.php';?>

    <div class="container">        
        <div class="row justify-content-md-center" style="padding:50px 0px;">
            <div class="col-12 col-md-7 text-center mb-4">
                <h2 class="h4">Crea una cuenta gratis y gestiona la agenda de tu negocio!</h2>
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
                    }
                    if ($_GET['error'] == "email_ya_registrado") { // Error 2
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Email ya registrado!</strong> Inicia sesion o intenta con otro correo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    } // Cierre if error 2
                    if ($_GET['error'] == "error_al_crear_usuario" || $_GET['error'] == "error_al_crear_cuenta" || $_GET['error'] == "error_interno") { // Error 3
                ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error al crear cuenta!</strong> Por favor intentalo de nuevo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                    } // Cierre if error 3              
                } //Cierre if de control isset
                ?>
                <form id="form-crear-cuenta" action="php/validaregistro_cuenta.php" method="post">
                    <div class="form-group">
                        <label for="nombre-usu-cuenta">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control campo-input" id="nombre-usu-cuenta" name="nombre-usu-cuenta" aria-describedby="nombreAyuda" placeholder="Escriba su nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos-usu-cuenta">Apellidos</label>
                        <input type="text" class="form-control campo-input" id="apellidos-usu-cuenta" name="apellidos-usu-cuenta" aria-describedby="apellidosAyuda" placeholder="Escriba sus apellidos">
                    </div>
                    <div class="form-group">
                        <label for="email-usu-cuenta">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control campo-input" id="email-usu-cuenta" name="email-usu-cuenta" aria-describedby="emailAyuda" placeholder="Escriba su email" required>
                    </div>
                    <div class="form-group">
                        <label for="celular-usu-cuenta">Celular</label>
                        <input type="tel" class="form-control campo-input" id="celular-usu-cuenta" name="celular-usu-cuenta" aria-describedby="celularAyuda" placeholder="Escriba su numero celular" pattern="[0-9]{10}">
                    </div>
                    <div class="form-group">
                        <label for="nombre-emp-cuenta">Nombre Empresa<span class="text-danger">*</span></label>
                        <input type="text" class="form-control campo-input" id="nombre-emp-cuenta" name="nombre-emp-cuenta" aria-describedby="nombreAyuda" placeholder="Escriba el nombre de su empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="nit-emp-cuenta">NIT o RUT Empresa<span class="text-danger">*</span></label>
                        <input type="text" class="form-control campo-input" id="nit-emp-cuenta" name="nit-emp-cuenta" aria-describedby="nombreAyuda" placeholder="Ejemplo: 900.123.456-7" required>
                    </div>
                    <div class="form-group">
                        <label for="password-usu-cuenta">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control campo-input" id="password-usu-cuenta" name="password-usu-cuenta" placeholder="Escriba una contraseña para su cuenta" required data-tipoInput="password">
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
