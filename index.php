<?php $titulo = "Ingreso";?>
<?php include_once'head.php';?>

<body>
    <div class="container contenedor-index">
        <div class="row" style="padding:80px 0px;">
            <div class="col text-center">
                Bienvenido
            </div>            
        </div>

        <p class="text-center">Si ya tienes cuenta ingresa</p>
        <!--Formulario de Login-->
        <form class="login-form" action="php/validalogin.php" method="post">
            
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Escriba su email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Escriba su clave">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block mt-5 btn-inicia-sesion">INICIAR SESION</button>
            </div>
        </form>
        
        <p class="pt-3 text-center">si no tienes cuenta registrate!</p>
        <a href="registro" type="button" class="btn btn-info btn-block boton-index">REGISTRARME</a>
        <div class="row px-3 py-5">
            
            
            <!--<a href="ingreso" type="button" class="btn btn-info btn-block boton-index">INGRESAR</a>-->
            
        </div>        
    </div>
</body>