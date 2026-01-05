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
                <form action="php/validaregistro_pg.php" method="post">
                    <input type="hidden" class="hidden" name="id_cuenta" id="id_cuenta" value="<?php echo htmlspecialchars($_GET["id_cuenta"],ENT_QUOTES)?>">
                    <div class="form-group">
                        <label for="nombre-reg">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control campo-input" id="nombre-reg" name="nombre-reg" aria-describedby="nombreAyuda" placeholder="Escriba su nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellidos-reg">Apellidos</label>
                        <input type="text" class="form-control campo-input" id="apellidos-reg" name="apellidos-reg" aria-describedby="apellidosAyuda" placeholder="Escriba sus apellidos">
                    </div>
                    <div class="form-group">
                        <label for="email-reg">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control campo-input" id="email-reg" name="email-reg" aria-describedby="emailAyuda" placeholder="Escriba su email" required>
                    </div>
                    <div class="form-group">
                        <label for="celular-reg">Celular</label>
                        <input type="tel" class="form-control campo-input" id="celular-reg" name="celular-reg" aria-describedby="celularAyuda" placeholder="Escriba su numero celular" pattern="[0-9]{10}">
                    </div>
                    <div class="form-group">
                        <label for="password-usu-cuenta">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control campo-input" id="clave-reg" name="clave-reg" placeholder="Escriba una contraseña para su cuenta" required data-tipoInput='password'>
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
