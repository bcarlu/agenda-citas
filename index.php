<?php $titulo = "Ingreso";?>
<?php include_once'head.php';?>

<body>
    <div class="container contenedor-index">
        <div class="row py-5">
            <div class="col-sm-12">
                <img src="img/logocalendar.png" class="mx-auto d-block pb-3" alt="Logo calendario">
            </div>            
            <div class="col-sm-12 text-center font-weight-bold">
                Bienvenido a Calendario
            </div>            
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <p class="pt-3 text-center text-muted">Eres nuevo?</p>
                <a href="registro" type="button" class="btn btn-block bt-crear-cuenta">Crear una cuenta</a>
            </div>
            
            <div class="col-sm-12 col-md-6">
                <p class="pt-3 text-center text-muted">Ya tienes cuenta?</p>
                <a href="ingreso" type="button" class="btn btn-block bt-ingresar">Ingresar</a>
            </div>            
        </div>
                  
 
    </div>
</body>