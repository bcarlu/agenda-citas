<?php $titulo = "Ingreso";?>
<?php include_once'head.php';?>

<body>

    <?php include_once'navloginreg.php';?>
    <div class="container">        
        <div class="row" style="padding:50px 0px;">
            <div class="col text-center">
                Logo
            </div>            
        </div>
        <!--Formulario de Login-->
        <form class="login-form" action="php/validalogin.php" method="post">
            <h2 class="text-center mb-3">Ingreso</h2>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Escriba su email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Escriba su clave">
            </div>
            <div class="form-group">
                <button type="submit" class="btn bt-ingresar btn-block mt-5">Ingresar</button>
            </div>
        </form>
        
        
    </div>        
</body>
</html>