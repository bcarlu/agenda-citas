<?php include_once'head.php';?>
<body>
    <div class="container">
    <h2 class="text-center py-5">Registro</h2>
    <form action="php/validaregistro.php" method="post">
        <div class="form-group mx-auto col-7">
            <label for="nom-ape">Nombre</label>
            <input type="text" class="form-control" id="nombre-reg" name="nombre-reg" aria-describedby="nombreAyuda" placeholder="Escriba su nombre" required>
        </div>
        <div class="form-group mx-auto col-7">
            <label for="nom-ape">Apellidos</label>
            <input type="text" class="form-control" id="apellidos-reg" name="apellidos-reg" aria-describedby="apellidosAyuda" placeholder="Escriba sus apellidos" required>
        </div>
        <div class="form-group mx-auto col-7">
            <label>Email</label>
            <input type="email" class="form-control" id="email-reg" name="email-reg" aria-describedby="emailAyuda" placeholder="Escriba su email" required>
        </div>
        <div class="form-group mx-auto col-7">
            <label>Celular</label>
            <input type="tel" class="form-control" id="celular-reg" name="celular-reg" aria-describedby="celularAyuda" placeholder="Escriba su numero celular" pattern="[0-9]{3}" required>
        </div>
        <div class="form-group mx-auto col-7">
            <label>Clave</label>
            <input type="password" class="form-control" id="clave-reg" name="clave-reg" placeholder="Escriba la clave que utilizara para iniciar sesión" required>
        </div>
        <div class="mx-auto col-7 text-center">
            <button type="submit" class="btn btn-success">Registrarme</button>
        </div>
    </form>
    </div>
</body>
</html>