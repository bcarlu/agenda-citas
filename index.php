<?php include_once'head.php';?>

<body class="index">
    <div class="container contenedor-app">
                
        <!--Formulario de Login-->
        <form class="login-form shadow p-3 mb-5" action="php/validalogin.php" method="post">
            <h2 class="text-center mb-5">Ingreso Luspa</h2>
            <div class="form-group mx-auto">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Escriba su email">
                <small id="emailHelp" class="form-text text-muted">Nunca compartiremos tus datos con nadie.</small>
            </div>
            <div class="form-group mx-auto">
                <label for="exampleInputPassword1">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Escriba su clave">
            </div>
            <div class="mx-auto text-center mb-3 mt-5">
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </div>
            <div class="mx-auto text-center">
                <a href="registro"><button type="button" class="btn btn-warning">Registrarme</button></a>
                <small id="registroAyuda" class="form-text text-muted">Si aún no tienes una cuenta te puedes registrar, es gratis.</small>
            </div>
        </form>
        
        
    </div>        
</body>
</html>