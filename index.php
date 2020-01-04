<?php include_once'head.php';?>

<body>
    <div class="container">
        
        <h2 class="text-center py-5">App Agenda tu cita</h2>
        
        <!--Formulario de Login-->
        <form action="php/validalogin.php" method="post">
            <div class="form-group mx-auto col-7">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Escriba su email">
                <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tus datos con nadie.</small>
            </div>
            <div class="form-group mx-auto col-7">
                <label for="exampleInputPassword1">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Escriba su clave">
            </div>
            <div class="mx-auto col-7 text-center">
            <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>
        </form>
        
        <div class="mx-auto col-7 text-center pt-4">
            <a href="registro"><button type="button" class="btn btn-warning">Registrarme</button></a>
            <small id="registroAyuda" class="form-text text-muted">Si aún no tienes una cuenta te puedes registrar, es gratis.</small>
        </div>
    </div>        
</body>
</html>