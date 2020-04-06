<?php $titulo = "Crear cuenta";?>
<?php include_once'head.php';?>
<body>
    
    <?php include_once'navloginreg.php';?>

    <div class="container">        
        <div class="row" style="padding:50px 0px;">
            <div class="col">
                <h2>Crea una cuenta gratis y agenda tus citas rapida y facilmente!</h2>
            </div>            
        </div>
        <form action="php/validaregistro" method="post">
            <div class="form-group">
                Nombre
                <input type="text" class="form-control campo-input" id="nombre-reg" name="nombre-reg" aria-describedby="nombreAyuda" placeholder="Escriba su nombre" required>
            </div>
            <div class="form-group">
                Apellidos
                <input type="text" class="form-control campo-input" id="apellidos-reg" name="apellidos-reg" aria-describedby="apellidosAyuda" placeholder="Escriba sus apellidos" required>
            </div>
            <div class="form-group">
                Email
                <input type="email" class="form-control campo-input" id="email-reg" name="email-reg" aria-describedby="emailAyuda" placeholder="Escriba su email" required>
            </div>
            <div class="form-group">
                Celular
                <input type="tel" class="form-control campo-input" id="celular-reg" name="celular-reg" aria-describedby="celularAyuda" placeholder="Escriba su numero celular" pattern="[0-9]{10}" required>
            </div>
            <div class="form-group">
                Contraseña
                <input type="password" class="form-control campo-input" id="passwd-reg" name="passwd-reg" placeholder="Escriba una contraseña para su cuenta" required>
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
</body>
</html>